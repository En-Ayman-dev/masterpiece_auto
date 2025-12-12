<?php
/**
 * PulseForge Auto Service - API: Get Car Models
 * يجلب بيانات السيارات من قاعدة البيانات.
 * يقوم بإنشاء الجدول والبيانات تلقائياً إذا لم تكن موجودة.
 */

// تضمين ملف الاتصال بقاعدة البيانات
require_once '../includes/db_connect.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // 1. التحقق من وجود الجدول وإنشائه إذا لزم الأمر
    ensureTableExists($pdo);

    // 2. استقبال المدخلات
    $type = $_GET['type'] ?? '';
    $value = $_GET['value'] ?? '';
    $year = $_GET['year'] ?? '';

    $results = [];

    // 3. معالجة الطلب
    if ($type === 'make') {
        // المستخدم اختار سنة ($value)، نحتاج الشركات المصنعة لهذه السنة
        $stmt = $pdo->prepare("SELECT DISTINCT make FROM car_models WHERE year = ? ORDER BY make ASC");
        $stmt->execute([$value]);
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($rows as $row) {
            $results[] = ['value' => $row, 'text' => $row];
        }

    } elseif ($type === 'model') {
        // المستخدم اختار شركة ($value)، نحتاج الموديلات (نحتاج السنة أيضاً)
        if (empty($year)) {
            throw new Exception("Year parameter is required for fetching models.");
        }

        $stmt = $pdo->prepare("SELECT DISTINCT model FROM car_models WHERE year = ? AND make = ? ORDER BY model ASC");
        $stmt->execute([$year, $value]);
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($rows as $row) {
            $results[] = ['value' => $row, 'text' => $row];
        }
    }

    echo json_encode(['success' => true, 'models' => $results]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

/**
 * دالة مساعدة للتأكد من وجود الجدول والبيانات
 */
function ensureTableExists($pdo)
{
    // التحقق مما إذا كان الجدول موجوداً
    $stmt = $pdo->query("SHOW TABLES LIKE 'car_models'");
    if ($stmt->rowCount() > 0) {
        // الجدول موجود، نتحقق من وجود بيانات
        $count = $pdo->query("SELECT COUNT(*) FROM car_models")->fetchColumn();
        if ($count > 0) {
            return; // كل شيء تمام
        }
    }

    // إنشاء الجدول إذا لم يكن موجوداً
    $sql_create = "CREATE TABLE IF NOT EXISTS `car_models` (
      `model_id` INT(11) NOT NULL AUTO_INCREMENT,
      `year` INT(4) NOT NULL,
      `make` VARCHAR(100) NOT NULL,
      `model` VARCHAR(100) NOT NULL,
      PRIMARY KEY (`model_id`),
      UNIQUE KEY `unique_car` (`year`, `make`, `model`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql_create);

    // إدخال بيانات أولية (Seeding)
    $sql_insert = "INSERT IGNORE INTO `car_models` (`year`, `make`, `model`) VALUES 
        (2024, 'Tesla', 'Model 3'), (2024, 'Tesla', 'Model S'), (2024, 'Tesla', 'Model X'), (2024, 'Tesla', 'Cybertruck'),
        (2023, 'Tesla', 'Model 3'), (2023, 'Tesla', 'Model Y'),
        (2024, 'BMW', 'X5'), (2024, 'BMW', 'X7'), (2024, 'BMW', 'M3'), (2024, 'BMW', 'i7'),
        (2023, 'BMW', 'X5'), (2023, 'BMW', '3 Series'),
        (2024, 'Mercedes-Benz', 'S-Class'), (2024, 'Mercedes-Benz', 'E-Class'), (2024, 'Mercedes-Benz', 'G-Class'),
        (2023, 'Mercedes-Benz', 'C-Class'), (2023, 'Mercedes-Benz', 'GLE'),
        (2024, 'Toyota', 'Camry'), (2024, 'Toyota', 'Land Cruiser'), (2024, 'Toyota', 'RAV4'),
        (2023, 'Toyota', 'Camry'), (2023, 'Toyota', 'Corolla'),
        (2024, 'Honda', 'Accord'), (2024, 'Honda', 'Civic'), (2024, 'Honda', 'CR-V'),
        (2024, 'Audi', 'A8'), (2024, 'Audi', 'Q8'), (2024, 'Audi', 'e-tron'),
        (2024, 'Porsche', '911'), (2024, 'Porsche', 'Cayenne'), (2024, 'Porsche', 'Taycan');";

    $pdo->exec($sql_insert);
}
?>