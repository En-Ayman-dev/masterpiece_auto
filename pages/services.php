<?php
/**
 * PulseForge Auto Service - Services Page
 * صفحة الخدمات - تعرض الخدمات المتاحة مع تفاصيل وتصميم احترافي
 */

include '../includes/header.php';

$is_rtl = ($current_lang === 'ar');

// نصوص المحتوى (Localization)
$services_content = [
    'ar' => [
        'page_title'       => 'خدماتنا المتميزة',
        'page_subtitle'    => 'حلول متكاملة لسيارتك بأعلى معايير الجودة والتكنولوجيا',
        'book_btn'         => 'احجز هذه الخدمة',
        'price_start'      => 'يبدأ من',
        'sar'              => 'ر.س',
        
        // خدمة الغسيل
        'wash_title'       => 'غسيل وتلميع نانو',
        'wash_desc'        => 'تكنولوجيا النانو سيراميك لحماية طلاء سيارتك مع تنظيف عميق للداخلية وتعقيم شامل.',
        'wash_feat_1'      => 'حماية نانو سيراميك',
        'wash_feat_2'      => 'تلميع ساطع',
        'wash_feat_3'      => 'تنظيف داخلي عميق',
        
        // خدمة الميكانيكا
        'mech_title'       => 'صيانة ميكانيكية دقيقة',
        'mech_desc'        => 'فحص كمبيوتر شامل وإصلاحات ميكانيكية دقيقة للمحرك وناقل الحركة باستخدام قطع غيار أصلية.',
        'mech_feat_1'      => 'فحص كمبيوتر مجاني',
        'mech_feat_2'      => 'قطع غيار أصلية',
        'mech_feat_3'      => 'ضمان على الإصلاح',
        
        // خدمة السمكرة
        'body_title'       => 'سمكرة ودهان احترافي',
        'body_desc'        => 'إعادة هيكل السيارة لحالته الأصلية باستخدام أحدث أفران الدهان وتقنيات الشفط بدون بوية.',
        'body_feat_1'      => 'ضمان الدهان 5 سنوات',
        'body_feat_2'      => 'مطابقة اللون 100%',
        'body_feat_3'      => 'سمكرة بدون دهان (PDR)',
    ],
    'en' => [
        'page_title'       => 'Our Premium Services',
        'page_subtitle'    => 'Integrated solutions for your car with the highest quality and technology standards',
        'book_btn'         => 'Book This Service',
        'price_start'      => 'Starts from',
        'sar'              => 'SAR',
        
        // Wash Service
        'wash_title'       => 'Nano Wash & Polish',
        'wash_desc'        => 'Nano-ceramic technology to protect your car paint with deep interior cleaning and sterilization.',
        'wash_feat_1'      => 'Nano Ceramic Protection',
        'wash_feat_2'      => 'High Gloss Polish',
        'wash_feat_3'      => 'Deep Interior Cleaning',
        
        // Mechanical Service
        'mech_title'       => 'Precision Mechanical Repair',
        'mech_desc'        => 'Comprehensive computer diagnostics and precise engine/transmission repairs using genuine parts.',
        'mech_feat_1'      => 'Free Computer Check',
        'mech_feat_2'      => 'Genuine Parts',
        'mech_feat_3'      => 'Repair Warranty',
        
        // Body Service
        'body_title'       => 'Professional Body & Paint',
        'body_desc'        => 'Restoring the car body to its original condition using the latest paint ovens and PDR techniques.',
        'body_feat_1'      => '5-Year Paint Warranty',
        'body_feat_2'      => '100% Color Match',
        'body_feat_3'      => 'Paintless Dent Repair (PDR)',
    ]
];

$t = $services_content[$current_lang];
?>

<section style="padding: 5rem 2rem; background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%); text-align: center; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; left: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(0,255,255,0.1) 0%, transparent 70%); border-radius: 50%; animation: pulse 5s infinite;"></div>
    <div style="position: absolute; bottom: -50px; right: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,107,53,0.1) 0%, transparent 70%); border-radius: 50%; animation: pulse 7s infinite reverse;"></div>

    <div class="container" style="position: relative; z-index: 2;">
        <h1 data-aos="zoom-in" style="color: var(--accent-cyan); font-size: 3rem; text-shadow: 0 0 15px var(--accent-cyan); margin-bottom: 1rem;">
            <?php echo $t['page_title']; ?>
        </h1>
        <p data-aos="fade-up" data-aos-delay="200" style="color: var(--text-muted); font-size: 1.2rem; max-width: 700px; margin: 0 auto;">
            <?php echo $t['page_subtitle']; ?>
        </p>
    </div>
</section>

<section style="padding: 4rem 2rem; background: var(--secondary-dark);">
    <div class="container">
        <div class="features-grid">
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="0" style="text-align: <?php echo $is_rtl ? 'right' : 'left'; ?>;">
                <div class="feature-icon" style="text-align: center;">
                    <i class="fas fa-droplet"></i>
                </div>
                <h3 style="text-align: center;"><?php echo $t['wash_title']; ?></h3>
                <p style="text-align: center; margin-bottom: 1.5rem;"><?php echo $t['wash_desc']; ?></p>
                
                <ul style="list-style: none; padding: 0; margin-bottom: 2rem; color: var(--text-light);">
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-check-circle" style="color: var(--accent-cyan);"></i> <?php echo $t['wash_feat_1']; ?></li>
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-check-circle" style="color: var(--accent-cyan);"></i> <?php echo $t['wash_feat_2']; ?></li>
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-check-circle" style="color: var(--accent-cyan);"></i> <?php echo $t['wash_feat_3']; ?></li>
                </ul>

                <div style="text-align: center; margin-top: auto;">
                    <div style="color: var(--accent-orange); font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">
                        <span style="font-size: 0.9rem; color: var(--text-muted);"><?php echo $t['price_start']; ?></span> 
                        150 <?php echo $t['sar']; ?>
                    </div>
                    <a href="booking_wizard.php?lang=<?php echo $current_lang; ?>" class="btn-neon" style="width: 100%;">
                        <?php echo $t['book_btn']; ?>
                    </a>
                </div>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="150" style="border-color: var(--accent-gold); text-align: <?php echo $is_rtl ? 'right' : 'left'; ?>;">
                <div class="feature-icon" style="text-align: center; color: var(--accent-gold);">
                    <i class="fas fa-wrench"></i>
                </div>
                <h3 style="text-align: center; color: var(--accent-gold);"><?php echo $t['mech_title']; ?></h3>
                <p style="text-align: center; margin-bottom: 1.5rem;"><?php echo $t['mech_desc']; ?></p>
                
                <ul style="list-style: none; padding: 0; margin-bottom: 2rem; color: var(--text-light);">
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-check-circle" style="color: var(--accent-gold);"></i> <?php echo $t['mech_feat_1']; ?></li>
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-check-circle" style="color: var(--accent-gold);"></i> <?php echo $t['mech_feat_2']; ?></li>
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-check-circle" style="color: var(--accent-gold);"></i> <?php echo $t['mech_feat_3']; ?></li>
                </ul>

                <div style="text-align: center; margin-top: auto;">
                    <div style="color: var(--accent-gold); font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">
                        <span style="font-size: 0.9rem; color: var(--text-muted);"><?php echo $t['price_start']; ?></span> 
                        200 <?php echo $t['sar']; ?>
                    </div>
                    <a href="booking_wizard.php?lang=<?php echo $current_lang; ?>" class="btn-neon" style="width: 100%; border-color: var(--accent-gold); color: var(--accent-gold);">
                        <?php echo $t['book_btn']; ?>
                    </a>
                </div>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300" style="border-color: var(--accent-orange); text-align: <?php echo $is_rtl ? 'right' : 'left'; ?>;">
                <div class="feature-icon" style="text-align: center; color: var(--accent-orange);">
                    <i class="fas fa-spray-can"></i>
                </div>
                <h3 style="text-align: center; color: var(--accent-orange);"><?php echo $t['body_title']; ?></h3>
                <p style="text-align: center; margin-bottom: 1.5rem;"><?php echo $t['body_desc']; ?></p>
                
                <ul style="list-style: none; padding: 0; margin-bottom: 2rem; color: var(--text-light);">
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-check-circle" style="color: var(--accent-orange);"></i> <?php echo $t['body_feat_1']; ?></li>
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-check-circle" style="color: var(--accent-orange);"></i> <?php echo $t['body_feat_2']; ?></li>
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-check-circle" style="color: var(--accent-orange);"></i> <?php echo $t['body_feat_3']; ?></li>
                </ul>

                <div style="text-align: center; margin-top: auto;">
                    <div style="color: var(--accent-orange); font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">
                        <span style="font-size: 0.9rem; color: var(--text-muted);"><?php echo $t['price_start']; ?></span> 
                        300 <?php echo $t['sar']; ?>
                    </div>
                    <a href="booking_wizard.php?lang=<?php echo $current_lang; ?>" class="btn-neon btn-orange" style="width: 100%;">
                        <?php echo $t['book_btn']; ?>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</section>

<section style="padding: 3rem 2rem; background: var(--primary-dark); text-align: center;">
    <div class="container" data-aos="fade-up" data-aos-offset="100">
        <h2 style="color: var(--text-light); margin-bottom: 2rem;">
            <?php echo $is_rtl ? 'نضمن لك الجودة في كل خطوة' : 'Quality Guaranteed at Every Step'; ?>
        </h2>
        <div style="display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap;">
            <div style="text-align: center;">
                <i class="fas fa-certificate" style="font-size: 2.5rem; color: var(--accent-cyan); margin-bottom: 1rem;"></i>
                <p><?php echo $is_rtl ? 'شهادة ضمان معتمدة' : 'Certified Warranty'; ?></p>
            </div>
            <div style="text-align: center;">
                <i class="fas fa-user-clock" style="font-size: 2.5rem; color: var(--accent-cyan); margin-bottom: 1rem;"></i>
                <p><?php echo $is_rtl ? 'تسليم في الموعد' : 'On-Time Delivery'; ?></p>
            </div>
            <div style="text-align: center;">
                <i class="fas fa-headset" style="font-size: 2.5rem; color: var(--accent-cyan); margin-bottom: 1rem;"></i>
                <p><?php echo $is_rtl ? 'دعم 24/7' : '24/7 Support'; ?></p>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes pulse {
    0% { transform: scale(1); opacity: 0.1; }
    50% { transform: scale(1.2); opacity: 0.3; }
    100% { transform: scale(1); opacity: 0.1; }
}
</style>

<?php include '../includes/footer.php'; ?>