<?php
/**
 * PulseForge Auto Service - API: Submit Booking
 * هذا الملف يستلم بيانات الحجز ويحفظها.
 * الميزة الجديدة: يقوم بإنشاء جداول (bookings, services, audit_log) تلقائياً إذا كانت مفقودة.
 */

require_once '../includes/db_connect.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // 1. التأكد من وجود البنية التحتية (الجداول)
    ensureTablesExist($pdo);

    // 2. استقبال البيانات
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!$data) {
        throw new Exception("لم يتم استلام أي بيانات.");
    }

    // 3. التحقق من الحقول
    $required = ['name', 'phone', 'service', 'year', 'make', 'model', 'date', 'time', 'problem'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            throw new Exception("الحقل '$field' مطلوب.");
        }
    }

    // 4. تحديد Service ID
    // الخريطة الثابتة لضمان تطابق المعرفات مع قاعدة البيانات
    $service_map = [
        'wash' => 1,
        'mechanical' => 2,
        'body_paint' => 3
    ];
    $service_id = $service_map[$data['service']] ?? 1;

    // 5. التعامل مع Car Model ID (إنشاء السيارة إذا لم تكن موجودة)
    $stmt = $pdo->prepare("SELECT model_id FROM car_models WHERE year = ? AND make = ? AND model = ? LIMIT 1");
    $stmt->execute([$data['year'], $data['make'], $data['model']]);
    $car_model_id = $stmt->fetchColumn();

    if (!$car_model_id) {
        // التأكد من وجود جدول السيارات أولاً (تحسباً)
        ensureCarTableExists($pdo);
        $stmt = $pdo->prepare("INSERT INTO car_models (year, make, model) VALUES (?, ?, ?)");
        $stmt->execute([$data['year'], $data['make'], $data['model']]);
        $car_model_id = $pdo->lastInsertId();
    }

    // 6. توليد كود تتبع فريد
    $tracking_code = generateUniqueTrackingCode($pdo);

    // 7. إدخال الحجز
    $sql = "INSERT INTO bookings (
                tracking_code, customer_name, customer_phone, 
                car_model_id, service_id, problem_description, 
                preferred_date, preferred_time, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'PENDING')";

    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        $tracking_code,
        $data['name'],
        $data['phone'],
        $car_model_id,
        $service_id,
        $data['problem'],
        $data['date'],
        $data['time']
    ]);

    if ($success) {
        $booking_id = $pdo->lastInsertId();

        // تسجيل العملية في Audit Log
        logAction($pdo, $booking_id, 'CREATE', 'PENDING', 'تم إنشاء الحجز عبر الموقع');

        echo json_encode([
            'success' => true,
            'tracking_code' => $tracking_code,
            'booking_id' => $booking_id,
            'message' => 'تم الحجز بنجاح'
        ]);
    } else {
        throw new Exception("فشل حفظ الحجز في قاعدة البيانات.");
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

// =============================================================
// Helper Functions (وظائف المساعدة والإنشاء الذاتي)
// =============================================================

function generateUniqueTrackingCode($pdo)
{
    $letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $max_attempts = 10;

    for ($i = 0; $i < $max_attempts; $i++) {
        $code = substr(str_shuffle($letters), 0, 3) . rand(1000, 9999);
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE tracking_code = ?");
        $stmt->execute([$code]);
        if ($stmt->fetchColumn() == 0) {
            return $code;
        }
    }
    return 'ERR' . rand(1000, 9999); // Fallback
}

function logAction($pdo, $booking_id, $action, $new_status, $notes)
{
    try {
        $stmt = $pdo->prepare("INSERT INTO audit_log (booking_id, action, new_status, notes) VALUES (?, ?, ?, ?)");
        $stmt->execute([$booking_id, $action, $new_status, $notes]);
    } catch (Exception $e) {
        // نغض الطرف عن أخطاء السجل لعدم تعطيل العملية الرئيسية
    }
}

function ensureCarTableExists($pdo)
{
    $pdo->exec("CREATE TABLE IF NOT EXISTS `car_models` (
      `model_id` INT(11) NOT NULL AUTO_INCREMENT,
      `year` INT(4) NOT NULL,
      `make` VARCHAR(100) NOT NULL,
      `model` VARCHAR(100) NOT NULL,
      PRIMARY KEY (`model_id`),
      UNIQUE KEY `unique_car` (`year`, `make`, `model`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
}

function ensureTablesExist($pdo)
{
    // 1. جدول الخدمات (Services)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `services` (
      `service_id` INT(11) NOT NULL AUTO_INCREMENT,
      `name_ar` VARCHAR(100) NOT NULL,
      `name_en` VARCHAR(100) NOT NULL,
      `icon_class` VARCHAR(50) DEFAULT NULL,
      PRIMARY KEY (`service_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // التحقق من وجود خدمات، وإلا إضافتها
    $count = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO `services` (`service_id`, `name_ar`, `name_en`, `icon_class`) VALUES
        (1, 'غسيل وتلميع', 'Wash & Polish', 'icon-wash'),
        (2, 'صيانة ميكانيكية', 'Mechanical Repair', 'icon-engine'),
        (3, 'إصلاح سمكرة ودهان', 'Body & Paint Repair', 'icon-body');");
    }

    // 2. جدول الحجوزات (Bookings)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `bookings` (
      `booking_id` INT(11) NOT NULL AUTO_INCREMENT,
      `tracking_code` VARCHAR(10) NOT NULL UNIQUE,
      `customer_name` VARCHAR(255) NOT NULL,
      `customer_phone` VARCHAR(20) NOT NULL,
      `customer_email` VARCHAR(255),
      `car_model_id` INT(11) NOT NULL,
      `service_id` INT(11) NOT NULL,
      `problem_description` TEXT,
      `preferred_date` DATE NOT NULL,
      `preferred_time` TIME NOT NULL,
      `status` VARCHAR(20) NOT NULL DEFAULT 'PENDING',
      `notes` TEXT,
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`booking_id`),
      KEY `idx_tracking_code` (`tracking_code`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 3. جدول السجلات (Audit Log)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `audit_log` (
      `log_id` INT(11) NOT NULL AUTO_INCREMENT,
      `booking_id` INT(11) NOT NULL,
      `action` VARCHAR(50) NOT NULL,
      `old_status` VARCHAR(50),
      `new_status` VARCHAR(50),
      `notes` TEXT,
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`log_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
}
?>