<?php
/**
 * PulseForge Auto Service - Home Page
 * الصفحة الرئيسية - Hero Section + Features + CTA
 */

include 'includes/header.php';

$is_rtl = ($current_lang === 'ar');

// Localized content
$home_content = [
    'ar' => [
        'hero_title' => 'النبض الآلي',
        'hero_subtitle' => 'حيث تلتقي الفخامة بالتكنولوجيا',
        'hero_desc' => 'نحن نعتني بمحرك سيارتك كما تستحق. خدمات صيانة متقدمة بأسلوب سينمائي.',
        'cta_button' => 'احجز الآن',
        'features_title' => 'لماذا تختار النبض الآلي؟',
        'feature_1_title' => 'تقنية متقدمة',
        'feature_1_desc' => 'أحدث أجهزة التشخيص والصيانة لضمان أداء سيارتك الأمثل.',
        'feature_2_title' => 'فريق محترف',
        'feature_2_desc' => 'تقنيون معتمدون بخبرة عشرات السنين في مجال الصيانة.',
        'feature_3_title' => 'ضمان شامل',
        'feature_3_desc' => 'كل خدمة مغطاة بضمان شامل وضمان رضا العميل 100%.',
        'feature_4_title' => 'متابعة فورية',
        'feature_4_desc' => 'تتبع حالة سيارتك لحظة بلحظة عبر نظامنا الذكي.',
    ],
    'en' => [
        'hero_title' => 'PulseForge',
        'hero_subtitle' => 'Where Luxury Meets Technology',
        'hero_desc' => 'We care for your engine as it deserves. Advanced maintenance services in cinematic style.',
        'cta_button' => 'Book Now',
        'features_title' => 'Why Choose PulseForge?',
        'feature_1_title' => 'Advanced Technology',
        'feature_1_desc' => 'Latest diagnostic and maintenance equipment to ensure optimal performance.',
        'feature_2_title' => 'Professional Team',
        'feature_2_desc' => 'Certified technicians with decades of experience in maintenance.',
        'feature_3_title' => 'Full Warranty',
        'feature_3_desc' => 'Every service covered by comprehensive warranty and 100% customer satisfaction.',
        'feature_4_title' => 'Live Tracking',
        'feature_4_desc' => 'Track your car status in real-time through our intelligent system.',
    ]
];

$content = $home_content[$current_lang];
?>

<!-- Loading Screen with Speedometer -->
<div class="loading-screen">
    <div class="speedometer">
        <div class="speedometer-text">
            <div style="font-size: 0.8rem;">Loading</div>
            <div style="font-size: 1.2rem;">⚡</div>
        </div>
    </div>
</div>

<!-- Hero Section with Parallax -->
<section class="hero">
    <!-- Parallax Background -->
    <div class="parallax-bg"
        style="background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 600%22><defs><linearGradient id=%22grad%22 x1=%220%25%22 y1=%220%25%22 x2=%22100%25%22 y2=%22100%25%22><stop offset=%220%25%22 style=%22stop-color:rgba(0,255,255,0.1);stop-opacity:1%22 /><stop offset=%22100%25%22 style=%22stop-color:rgba(255,107,53,0.1);stop-opacity:1%22 /></linearGradient></defs><rect width=%221200%22 height=%22600%22 fill=%22url(%23grad)%22/><circle cx=%22200%22 cy=%22150%22 r=%22100%22 fill=%22rgba(0,255,255,0.05)%22/><circle cx=%221000%22 cy=%22450%22 r=%22150%22 fill=%22rgba(255,107,53,0.05)%22/></svg>') center/cover;">
    </div>

    <!-- Hero Content -->
    <div class="hero-content" data-aos="fade-up">
        <h1 class="typewriter"><?php echo $content['hero_title']; ?></h1>
        <p style="font-size: 1.3rem; color: var(--accent-orange); margin-bottom: 1.5rem;">
            <?php echo $content['hero_subtitle']; ?>
        </p>
        <p><?php echo $content['hero_desc']; ?></p>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="pages/booking_wizard.php?lang=<?php echo $current_lang; ?>" class="btn-neon">
                <i class="fas fa-calendar-check"></i> <?php echo $content['cta_button']; ?>
            </a>
            <a href="pages/track_status.php?lang=<?php echo $current_lang; ?>" class="btn-neon btn-orange">
                <i class="fas fa-map-location-dot"></i> <?php echo $is_rtl ? 'تتبع الحالة' : 'Track Status'; ?>
            </a>
        </div>

        <a href="pages/booking_wizard.php?lang=<?php echo $current_lang; ?>" class="btn-neon btn-orange"
            style="font-size: 1.1rem; padding: 15px 40px;">
            <i class="fas fa-rocket"></i> <?php echo $is_rtl ? 'ابدأ الحجز الآن' : 'Start Booking Now'; ?>
        </a>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <h2
            style="text-align: center; font-size: 2.5rem; color: var(--accent-cyan); margin-bottom: 3rem; text-shadow: 0 0 10px var(--accent-cyan);">
            <?php echo $content['features_title']; ?>
        </h2>

        <div class="features-grid">
            <!-- Feature 1: Advanced Technology -->
            <div class="feature-card" data-aos="fade-up" data-aos-delay="0">
                <div class="feature-icon">
                    <i class="fas fa-microchip"></i>
                </div>
                <h3><?php echo $content['feature_1_title']; ?></h3>
                <p><?php echo $content['feature_1_desc']; ?></p>
            </div>

            <!-- Feature 2: Professional Team -->
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3><?php echo $content['feature_2_title']; ?></h3>
                <p><?php echo $content['feature_2_desc']; ?></p>
            </div>

            <!-- Feature 3: Full Warranty -->
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-shield-check"></i>
                </div>
                <h3><?php echo $content['feature_3_title']; ?></h3>
                <p><?php echo $content['feature_3_desc']; ?></p>
            </div>

            <!-- Feature 4: Live Tracking -->
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-location-dot"></i>
                </div>
                <h3><?php echo $content['feature_4_title']; ?></h3>
                <p><?php echo $content['feature_4_desc']; ?></p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section
    style="padding: 4rem 2rem; background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%); text-align: center;">
    <div class="container">
        <h2 style="color: var(--accent-cyan); margin-bottom: 1rem; font-size: 2rem;">
            <?php echo $is_rtl ? 'هل أنت مستعد لتجربة الفخامة؟' : 'Ready for the Ultimate Experience?'; ?>
        </h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 1.1rem;">
            <?php echo $is_rtl ? 'احجز موعدك الآن واستمتع بخدمات صيانة من الدرجة الأولى' : 'Book your appointment now and enjoy first-class maintenance services'; ?>
        </p>
        <a href="/pages/booking_wizard.php?lang=<?php echo $current_lang; ?>" class="btn-neon btn-orange"
            style="font-size: 1.1rem; padding: 15px 40px;">
            <i class="fas fa-rocket"></i> <?php echo $is_rtl ? 'ابدأ الحجز الآن' : 'Start Booking Now'; ?>
        </a>
    </div>
</section>

<!-- Typewriter Effect Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize typewriter effect
        const titleElement = document.querySelector('.typewriter');
        if (titleElement) {
            const text = titleElement.textContent;
            titleElement.textContent = '';
            let index = 0;

            function type() {
                if (index < text.length) {
                    titleElement.textContent += text.charAt(index);
                    index++;
                    setTimeout(type, 100);
                }
            }

            type();
        }
    });
</script>

<?php include 'includes/footer.php'; ?>