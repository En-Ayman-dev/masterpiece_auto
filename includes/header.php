<?php
/**
 * PulseForge Auto Service - Header Template
 * تم التحديث: إصلاح مشكلة المسارات (Dynamic Pathing)
 */

// تحديد اللغة الحالية
$current_lang = $_GET['lang'] ?? 'ar';
$is_rtl = ($current_lang === 'ar');
$lang_toggle = ($current_lang === 'ar') ? 'en' : 'ar';

// --- [FIX START] نظام تحديد المسار الديناميكي ---
// التحقق مما إذا كنا داخل مجلد فرعي (مثل pages)
$in_pages_dir = strpos($_SERVER['SCRIPT_NAME'], '/pages/') !== false;
// إذا كنا في صفحة داخلية نعود للخلف خطوة (../)، وإلا نبقى في الجذر (./)
$base_path = $in_pages_dir ? '../' : './';
// --- [FIX END] ---

$texts = [
    'ar' => [
        'home'      => 'الرئيسية',
        'services'  => 'الخدمات',
        'booking'   => 'احجز الآن',
        'track'     => 'تتبع حالتك',
        'contact'   => 'اتصل بنا',
        'language'  => 'English'
    ],
    'en' => [
        'home'      => 'Home',
        'services'  => 'Services',
        'booking'   => 'Book Now',
        'track'     => 'Track Status',
        'contact'   => 'Contact Us',
        'language'  => 'العربية'
    ]
];

$t = $texts[$current_lang];
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>" dir="<?php echo $is_rtl ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PulseForge - خدمات السيارات الفخمة والمتقدمة">
    <meta name="theme-color" content="#0a0e27">
    
    <title>PulseForge | النبض الآلي - خدمات السيارات الفخمة</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        <?php if ($is_rtl): ?>
            body { font-family: 'Cairo', sans-serif; }
            .navbar-nav { flex-direction: row-reverse; }
            .nav-link { margin-<?php echo $is_rtl ? 'right' : 'left'; ?>: 1.5rem; }
        <?php else: ?>
            body { font-family: 'Poppins', sans-serif; }
        <?php endif; ?>
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark fixed-top" style="background: linear-gradient(135deg, #0a0e27 0%, #1a1f3a 100%) !important; box-shadow: 0 0 20px rgba(0, 255, 255, 0.1);">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $base_path; ?>index.php?lang=<?php echo $current_lang; ?>" style="font-size: 1.5rem; font-weight: 700; color: #00ffff !important; text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);">
                <i class="fas fa-bolt"></i> PulseForge
            </a>
            
            <div class="navbar-nav" style="display: flex; gap: 1rem;">
                <a class="nav-link" href="<?php echo $base_path; ?>index.php?lang=<?php echo $current_lang; ?>"><?php echo $t['home']; ?></a>
                <a class="nav-link" href="<?php echo $base_path; ?>pages/services.php?lang=<?php echo $current_lang; ?>"><?php echo $t['services']; ?></a>
                <a class="nav-link" href="<?php echo $base_path; ?>pages/booking_wizard.php?lang=<?php echo $current_lang; ?>"><?php echo $t['booking']; ?></a>
                <a class="nav-link" href="<?php echo $base_path; ?>pages/track_status.php?lang=<?php echo $current_lang; ?>"><?php echo $t['track']; ?></a>
                
                <a class="nav-link" href="?lang=<?php echo $lang_toggle; ?>" style="background: rgba(0, 255, 255, 0.1); padding: 0.5rem 1rem; border-radius: 5px; border: 1px solid #00ffff;">
                    <i class="fas fa-globe"></i> <?php echo $t['language']; ?>
                </a>
            </div>
        </div>
    </nav>
    
    <div style="height: 70px;"></div>