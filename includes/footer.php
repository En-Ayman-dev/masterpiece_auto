<?php
/**
 * PulseForge Auto Service - Footer Template
 * ذيل الصفحة - يحتوي على معلومات التواصل والروابط والإغلاقات.
 */

$current_lang = $_GET['lang'] ?? 'ar';
$is_rtl = ($current_lang === 'ar');

$footer_texts = [
    'ar' => [
        'about'     => 'عن النبض الآلي',
        'services'  => 'الخدمات',
        'contact'   => 'اتصل بنا',
        'phone'     => 'الهاتف',
        'email'     => 'البريد الإلكتروني',
        'address'   => 'العنوان',
        'copyright' => 'جميع الحقوق محفوظة © 2024 النبض الآلي'
    ],
    'en' => [
        'about'     => 'About PulseForge',
        'services'  => 'Services',
        'contact'   => 'Contact Us',
        'phone'     => 'Phone',
        'email'     => 'Email',
        'address'   => 'Address',
        'copyright' => 'All rights reserved © 2024 PulseForge'
    ]
];

$ft = $footer_texts[$current_lang];
?>

    <!-- Footer -->
    <footer style="background: linear-gradient(135deg, #0a0e27 0%, #1a1f3a 100%); color: #00ffff; padding: 3rem 0; margin-top: 5rem; border-top: 2px solid rgba(0, 255, 255, 0.2);">
        <div class="container">
            <div class="row" style="text-align: <?php echo $is_rtl ? 'right' : 'left'; ?>;">
                <!-- About Section -->
                <div class="col-md-3 mb-4">
                    <h5 style="color: #00ffff; font-weight: 700; margin-bottom: 1rem;">
                        <i class="fas fa-bolt"></i> PulseForge
                    </h5>
                    <p style="color: #b0b0b0; font-size: 0.9rem;">
                        <?php echo $is_rtl ? 'منصة متقدمة لخدمات السيارات الفخمة مع تقنيات حديثة وتجربة عميل استثنائية.' : 'Advanced platform for luxury car services with modern technology and exceptional customer experience.'; ?>
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div class="col-md-3 mb-4">
                    <h5 style="color: #00ffff; font-weight: 700; margin-bottom: 1rem;"><?php echo $ft['services']; ?></h5>
                    <ul style="list-style: none; padding: 0;">
                        <li><a href="#" style="color: #b0b0b0; text-decoration: none; transition: 0.3s;">• <?php echo $is_rtl ? 'غسيل وتلميع' : 'Wash & Polish'; ?></a></li>
                        <li><a href="#" style="color: #b0b0b0; text-decoration: none; transition: 0.3s;">• <?php echo $is_rtl ? 'صيانة ميكانيكية' : 'Mechanical Repair'; ?></a></li>
                        <li><a href="#" style="color: #b0b0b0; text-decoration: none; transition: 0.3s;">• <?php echo $is_rtl ? 'إصلاح سمكرة' : 'Body & Paint'; ?></a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="col-md-3 mb-4">
                    <h5 style="color: #00ffff; font-weight: 700; margin-bottom: 1rem;"><?php echo $ft['contact']; ?></h5>
                    <p style="color: #b0b0b0; margin-bottom: 0.5rem;">
                        <i class="fas fa-phone"></i> +966 50 123 4567
                    </p>
                    <p style="color: #b0b0b0; margin-bottom: 0.5rem;">
                        <i class="fas fa-envelope"></i> info@pulseforge.com
                    </p>
                    <p style="color: #b0b0b0;">
                        <i class="fas fa-map-marker-alt"></i> <?php echo $is_rtl ? 'الرياض، المملكة العربية السعودية' : 'Riyadh, Saudi Arabia'; ?>
                    </p>
                </div>
                
                <!-- Social Links -->
                <div class="col-md-3 mb-4">
                    <h5 style="color: #00ffff; font-weight: 700; margin-bottom: 1rem;"><?php echo $is_rtl ? 'تابعنا' : 'Follow Us'; ?></h5>
                    <div style="display: flex; gap: 1rem;">
                        <a href="#" style="color: #00ffff; font-size: 1.5rem; transition: 0.3s; text-decoration: none;">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" style="color: #00ffff; font-size: 1.5rem; transition: 0.3s; text-decoration: none;">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" style="color: #00ffff; font-size: 1.5rem; transition: 0.3s; text-decoration: none;">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <hr style="border-color: rgba(0, 255, 255, 0.2); margin: 2rem 0;">
            <div style="text-align: center; color: #888; font-size: 0.9rem;">
                <p><?php echo $ft['copyright']; ?></p>
            </div>
        </div>
    </footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script src="<?php echo $base_path; ?>assets/js/main.js"></script>
    
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    </script>
</body>
</html>
