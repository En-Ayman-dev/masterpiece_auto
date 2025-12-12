-- =====================================================
-- PulseForge Auto Service - Database Setup Script
-- =====================================================
-- هذا الملف يحتوي على كل الأوامر SQL اللازمة لإنشاء
-- قاعدة البيانات والجداول والبيانات الأولية

-- =====================================================
-- 1. إنشاء قاعدة البيانات
-- =====================================================
CREATE DATABASE IF NOT EXISTS pulseforge_auto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pulseforge_auto;

-- =====================================================
-- 2. جدول الخدمات (services)
-- =====================================================
-- لتخزين أنواع الخدمات المقدمة (غسيل، ميكانيكا، سمكرة)
CREATE TABLE IF NOT EXISTS `services` (
  `service_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name_ar` VARCHAR(100) NOT NULL COMMENT 'اسم الخدمة بالعربية',
  `name_en` VARCHAR(100) NOT NULL COMMENT 'اسم الخدمة بالإنجليزية',
  `icon_class` VARCHAR(50) DEFAULT NULL COMMENT 'فئة الأيقونة (FontAwesome أو مخصصة)',
  `description_ar` TEXT COMMENT 'وصف الخدمة بالعربية',
  `description_en` TEXT COMMENT 'وصف الخدمة بالإنجليزية',
  `price_range` VARCHAR(50) COMMENT 'نطاق السعر (مثل: 100-500)',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- إدخال بيانات أولية للخدمات
INSERT INTO `services` (`name_ar`, `name_en`, `icon_class`, `description_ar`, `description_en`, `price_range`) VALUES
('غسيل وتلميع', 'Wash & Polish', 'icon-wash', 'غسيل شامل للسيارة مع تلميع احترافي', 'Complete car wash with professional polishing', '50-150'),
('صيانة ميكانيكية', 'Mechanical Repair', 'icon-engine', 'صيانة وإصلاح جميع الأجزاء الميكانيكية', 'Maintenance and repair of all mechanical parts', '200-1000'),
('إصلاح سمكرة ودهان', 'Body & Paint Repair', 'icon-body', 'إصلاح الهياكل والدهان بأعلى جودة', 'Frame repair and painting with highest quality', '300-2000');

-- =====================================================
-- 3. جدول موديلات السيارات (car_models)
-- =====================================================
-- لتوفير قوائم منسدلة ذكية (سنة الصنع -> الشركة -> الموديل)
CREATE TABLE IF NOT EXISTS `car_models` (
  `model_id` INT(11) NOT NULL AUTO_INCREMENT,
  `year` YEAR NOT NULL COMMENT 'سنة الصنع',
  `make` VARCHAR(100) NOT NULL COMMENT 'الشركة المصنعة (مثل Tesla, BMW)',
  `model` VARCHAR(100) NOT NULL COMMENT 'الموديل (مثل Model 3, X5)',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`model_id`),
  UNIQUE KEY `unique_car` (`year`, `make`, `model`),
  KEY `idx_year_make` (`year`, `make`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- إدخال بيانات أولية للسيارات
INSERT INTO `car_models` (`year`, `make`, `model`) VALUES
(2024, 'Tesla', 'Model 3'),
(2024, 'Tesla', 'Model S'),
(2024, 'Tesla', 'Model X'),
(2023, 'Tesla', 'Model 3'),
(2023, 'Tesla', 'Model S'),
(2024, 'BMW', 'X5'),
(2024, 'BMW', 'X7'),
(2024, 'BMW', '7 Series'),
(2023, 'BMW', 'X5'),
(2023, 'BMW', '5 Series'),
(2024, 'Mercedes-Benz', 'S-Class'),
(2024, 'Mercedes-Benz', 'E-Class'),
(2024, 'Mercedes-Benz', 'GLE'),
(2023, 'Mercedes-Benz', 'S-Class'),
(2023, 'Mercedes-Benz', 'C-Class'),
(2024, 'Toyota', 'Camry'),
(2024, 'Toyota', 'Corolla'),
(2024, 'Toyota', 'RAV4'),
(2023, 'Toyota', 'Camry'),
(2023, 'Toyota', 'Highlander'),
(2024, 'Honda', 'Accord'),
(2024, 'Honda', 'Civic'),
(2024, 'Honda', 'CR-V'),
(2023, 'Honda', 'Accord'),
(2023, 'Honda', 'Pilot'),
(2024, 'Audi', 'A4'),
(2024, 'Audi', 'A6'),
(2024, 'Audi', 'Q5'),
(2023, 'Audi', 'A4'),
(2023, 'Audi', 'Q7');

-- =====================================================
-- 4. جدول الحجوزات (bookings)
-- =====================================================
-- لتخزين تفاصيل الحجز ومتابعة حالة السيارة
CREATE TABLE IF NOT EXISTS `bookings` (
  `booking_id` INT(11) NOT NULL AUTO_INCREMENT,
  `tracking_code` VARCHAR(10) NOT NULL UNIQUE COMMENT 'كود فريد لمتابعة الحجز',
  `customer_name` VARCHAR(255) NOT NULL COMMENT 'اسم العميل',
  `customer_phone` VARCHAR(20) NOT NULL COMMENT 'رقم هاتف العميل',
  `customer_email` VARCHAR(255) COMMENT 'بريد العميل الإلكتروني',
  `car_model_id` INT(11) NOT NULL COMMENT 'مفتاح خارجي لجدول car_models',
  `service_id` INT(11) NOT NULL COMMENT 'مفتاح خارجي لجدول services',
  `problem_description` TEXT COMMENT 'وصف المشكلة من العميل',
  `preferred_date` DATE NOT NULL COMMENT 'التاريخ المفضل للحجز',
  `preferred_time` TIME NOT NULL COMMENT 'الوقت المفضل للحجز',
  `status` ENUM('PENDING', 'RECEIVED', 'IN_SERVICE', 'READY', 'COMPLETED') NOT NULL DEFAULT 'PENDING' COMMENT 'حالة الحجز',
  `notes` TEXT COMMENT 'ملاحظات إضافية من الفريق',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'وقت إنشاء الحجز',
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'آخر تحديث',
  PRIMARY KEY (`booking_id`),
  UNIQUE KEY `unique_tracking_code` (`tracking_code`),
  FOREIGN KEY (`car_model_id`) REFERENCES `car_models`(`model_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`service_id`) ON DELETE RESTRICT,
  KEY `idx_tracking_code` (`tracking_code`),
  KEY `idx_status` (`status`),
  KEY `idx_date` (`preferred_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. جدول السجل (audit_log)
-- =====================================================
-- لتسجيل جميع التغييرات على الحجوزات
CREATE TABLE IF NOT EXISTS `audit_log` (
  `log_id` INT(11) NOT NULL AUTO_INCREMENT,
  `booking_id` INT(11) NOT NULL,
  `action` VARCHAR(50) NOT NULL COMMENT 'نوع الإجراء (CREATE, UPDATE, DELETE)',
  `old_status` VARCHAR(50) COMMENT 'الحالة السابقة',
  `new_status` VARCHAR(50) COMMENT 'الحالة الجديدة',
  `notes` TEXT COMMENT 'ملاحظات الإجراء',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`booking_id`) ON DELETE CASCADE,
  KEY `idx_booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. مؤشرات (Indexes) لتحسين الأداء
-- =====================================================
CREATE INDEX idx_bookings_customer ON bookings(customer_phone);
CREATE INDEX idx_bookings_service ON bookings(service_id);
CREATE INDEX idx_bookings_car ON bookings(car_model_id);
CREATE INDEX idx_bookings_created_at ON bookings(created_at);

-- =====================================================
-- 7. عرض (View) لمعلومات الحجز الكاملة
-- =====================================================
CREATE OR REPLACE VIEW booking_details AS
SELECT 
    b.booking_id,
    b.tracking_code,
    b.customer_name,
    b.customer_phone,
    s.name_ar AS service_ar,
    s.name_en AS service_en,
    CONCAT(cm.year, ' ', cm.make, ' ', cm.model) AS car_full_name,
    b.problem_description,
    b.preferred_date,
    b.preferred_time,
    b.status,
    b.created_at,
    b.updated_at
FROM bookings b
INNER JOIN services s ON b.service_id = s.service_id
INNER JOIN car_models cm ON b.car_model_id = cm.model_id;

-- =====================================================
-- 8. إجراء مخزن (Stored Procedure) لإنشاء حجز جديد
-- =====================================================
DELIMITER //

CREATE PROCEDURE create_booking(
    IN p_customer_name VARCHAR(255),
    IN p_customer_phone VARCHAR(20),
    IN p_car_model_id INT,
    IN p_service_id INT,
    IN p_problem_description TEXT,
    IN p_preferred_date DATE,
    IN p_preferred_time TIME,
    OUT p_tracking_code VARCHAR(10),
    OUT p_booking_id INT
)
BEGIN
    DECLARE v_tracking_code VARCHAR(10);
    DECLARE v_exists INT;
    
    -- Generate unique tracking code
    REPEAT
        SET v_tracking_code = CONCAT(
            CHAR(65 + FLOOR(RAND() * 26)),
            CHAR(65 + FLOOR(RAND() * 26)),
            CHAR(65 + FLOOR(RAND() * 26)),
            LPAD(FLOOR(RAND() * 10000), 4, '0')
        );
        
        SELECT COUNT(*) INTO v_exists FROM bookings WHERE tracking_code = v_tracking_code;
    UNTIL v_exists = 0 END REPEAT;
    
    -- Insert booking
    INSERT INTO bookings (
        tracking_code,
        customer_name,
        customer_phone,
        car_model_id,
        service_id,
        problem_description,
        preferred_date,
        preferred_time,
        status
    ) VALUES (
        v_tracking_code,
        p_customer_name,
        p_customer_phone,
        p_car_model_id,
        p_service_id,
        p_problem_description,
        p_preferred_date,
        p_preferred_time,
        'PENDING'
    );
    
    SET p_tracking_code = v_tracking_code;
    SET p_booking_id = LAST_INSERT_ID();
    
    -- Log the action
    INSERT INTO audit_log (booking_id, action, new_status, notes)
    VALUES (p_booking_id, 'CREATE', 'PENDING', 'Booking created');
END //

DELIMITER ;

-- =====================================================
-- 9. إجراء مخزن (Stored Procedure) لتحديث حالة الحجز
-- =====================================================
DELIMITER //

CREATE PROCEDURE update_booking_status(
    IN p_booking_id INT,
    IN p_new_status VARCHAR(50),
    IN p_notes TEXT
)
BEGIN
    DECLARE v_old_status VARCHAR(50);
    
    -- Get current status
    SELECT status INTO v_old_status FROM bookings WHERE booking_id = p_booking_id;
    
    -- Update status
    UPDATE bookings 
    SET status = p_new_status 
    WHERE booking_id = p_booking_id;
    
    -- Log the change
    INSERT INTO audit_log (booking_id, action, old_status, new_status, notes)
    VALUES (p_booking_id, 'UPDATE', v_old_status, p_new_status, p_notes);
END //

DELIMITER ;

-- =====================================================
-- 10. بيانات تجريبية (Demo Data)
-- =====================================================
INSERT INTO `bookings` 
(`tracking_code`, `customer_name`, `customer_phone`, `car_model_id`, `service_id`, `problem_description`, `preferred_date`, `preferred_time`, `status`)
VALUES
('ABC1234', 'أحمد محمد', '+966501234567', 1, 2, 'صوت غريب من المحرك', '2024-12-15', '10:30:00', 'IN_SERVICE'),
('XYZ5678', 'فاطمة علي', '+966509876543', 6, 1, 'تنظيف شامل للسيارة', '2024-12-16', '14:00:00', 'PENDING'),
('DEF9012', 'محمد سالم', '+966505555555', 11, 3, 'إصلاح الخدش على الباب الأيسر', '2024-12-17', '09:00:00', 'RECEIVED');

-- =====================================================
-- 11. معلومات الاتصال
-- =====================================================
-- تم إنشاء قاعدة البيانات بنجاح!
-- يمكنك الآن الاتصال باستخدام:
-- Host: sqlxxx.infinityfree.com (استبدل بعنوان خادمك)
-- Database: pulseforge_auto
-- User: root أو اسم المستخدم الخاص بك
-- Password: كلمة المرور الخاصة بك
