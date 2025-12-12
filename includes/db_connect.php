<?php
/**
 * PulseForge Auto Service - Database Connection File
 * ملف اتصال قاعدة البيانات - يستخدم PDO لاتصال آمن وفعال.
 *
 * تم إعداده لبيئة استضافة مشتركة مثل InfinityFree.
 * يجب استبدال القيم التالية ببيانات قاعدة البيانات الخاصة بك.
 */

// تعريف ثوابت الاتصال
// تعريف ثوابت الاتصال
define('DB_HOST', 'localhost'); // استبدل بعنوان خادم قاعدة البيانات
define('DB_NAME', 'pulseforge'); // استبدل باسم قاعدة البيانات
define('DB_USER', 'root');            // استبدل باسم مستخدم قاعدة البيانات
define('DB_PASS', '');    // استبدل بكلمة المرور
// define('DB_HOST', 'sql108.infinityfree.com'); // استبدل بعنوان خادم قاعدة البيانات
// define('DB_NAME', 'if0_40668810_pulseforge'); // استبدل باسم قاعدة البيانات
// define('DB_USER', 'if0_40668810');            // استبدل باسم مستخدم قاعدة البيانات
// define('DB_PASS', 'hXMCH4jLc8');    // استبدل بكلمة المرور

// إعداد خيارات PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // تفعيل وضع الاستثناءات للأخطاء
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // جلب البيانات كمصفوفة ترابطية
    PDO::ATTR_EMULATE_PREPARES   => false,                  // إيقاف تشغيل المحاكاة لتحسين الأمان والأداء
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"     // التأكد من دعم اللغة العربية والرموز
];

// سلسلة الاتصال (DSN)
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

try {
    // إنشاء كائن الاتصال
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
    // في حالة فشل الاتصال، عرض رسالة خطأ أنيقة
    http_response_code(500);
    die("<h1>خطأ في الاتصال بقاعدة البيانات</h1><p>نعتذر، لا يمكننا الاتصال بخدماتنا حالياً. يرجى المحاولة لاحقاً.</p>");
}
