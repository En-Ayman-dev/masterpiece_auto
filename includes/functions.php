<?php
/**
 * PulseForge Auto Service - Helper Functions
 * ملف الدوال المساعدة - يحتوي على دوال شائعة للتحقق من المدخلات والعمليات العامة.
 */

/**
 * تنظيف وتحقق من صحة المدخلات (Sanitize Input)
 * يزيل الرموز الخاصة والمسافات الزائدة
 */
function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * التحقق من صحة البريد الإلكتروني
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * التحقق من صحة رقم الهاتف (أرقام فقط، 10-15 رقم)
 */
function validate_phone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return strlen($phone) >= 10 && strlen($phone) <= 15;
}

/**
 * توليد كود فريد لمتابعة الحجز (6 أحرف عشوائية + 4 أرقام)
 * مثال: ABC1234
 */
function generate_tracking_code() {
    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    
    // إضافة 3 أحرف عشوائية
    for ($i = 0; $i < 3; $i++) {
        $code .= $letters[rand(0, strlen($letters) - 1)];
    }
    
    // إضافة 4 أرقام عشوائية
    $code .= rand(1000, 9999);
    
    return $code;
}

/**
 * تحويل حالة الحجز إلى نص عربي وصفي
 */
function get_status_text($status) {
    $statuses = [
        'PENDING'    => 'قيد الانتظار',
        'RECEIVED'   => 'تم الاستقبال',
        'IN_SERVICE' => 'قيد الصيانة',
        'READY'      => 'جاهزة للاستلام',
        'COMPLETED'  => 'مكتملة'
    ];
    
    return $statuses[$status] ?? 'غير معروف';
}

/**
 * تحويل حالة الحجز إلى رمز لوني (للعرض في الواجهة)
 */
function get_status_color($status) {
    $colors = [
        'PENDING'    => '#FFA500', // برتقالي
        'RECEIVED'   => '#00BFFF', // أزرق سماوي
        'IN_SERVICE' => '#FFD700', // ذهبي
        'READY'      => '#00FF00', // أخضر
        'COMPLETED'  => '#00CED1'  // فيروزي
    ];
    
    return $colors[$status] ?? '#CCCCCC';
}

/**
 * تنسيق التاريخ إلى صيغة عربية (مثل: 15 ديسمبر 2024)
 */
function format_date_ar($date) {
    $months_ar = [
        'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو',
        'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
    ];
    
    $date_obj = new DateTime($date);
    $day = $date_obj->format('d');
    $month = $months_ar[(int)$date_obj->format('m') - 1];
    $year = $date_obj->format('Y');
    
    return "$day $month $year";
}

/**
 * تحويل الوقت إلى صيغة 12 ساعة (مثل: 2:30 م)
 */
function format_time_12h($time) {
    $time_obj = DateTime::createFromFormat('H:i:s', $time);
    if (!$time_obj) {
        $time_obj = DateTime::createFromFormat('H:i', $time);
    }
    return $time_obj->format('h:i A');
}

/**
 * تسجيل الأخطاء في ملف log
 */
function log_error($message, $file = 'error.log') {
    $log_file = __DIR__ . '/../' . $file;
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] $message\n";
    file_put_contents($log_file, $log_message, FILE_APPEND);
}

/**
 * إرسال استجابة JSON (مفيدة للطلبات AJAX)
 */
function send_json_response($success, $message = '', $data = []) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data'    => $data
    ]);
    exit;
}
