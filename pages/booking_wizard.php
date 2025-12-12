<?php
/**
 * PulseForge Auto Service - Booking Wizard Page
 * صفحة نظام الحجز الذكي - The Wizard (4 Steps)
 */

include '../includes/header.php';
include '../includes/functions.php';

$is_rtl = ($current_lang === 'ar');

// Localized content
$wizard_content = [
    'ar' => [
        'page_title'      => 'نظام الحجز الذكي',
        'step_1_title'    => 'اختر الخدمة',
        'step_1_desc'     => 'ما نوع الخدمة التي تحتاج إليها؟',
        'step_2_title'    => 'تفاصيل السيارة',
        'step_2_desc'     => 'أخبرنا عن سيارتك',
        'step_3_title'    => 'وصف المشكلة',
        'step_3_desc'     => 'ما المشكلة التي تواجهها؟',
        'step_4_title'    => 'معلومات التواصل',
        'step_4_desc'     => 'أكمل بياناتك الشخصية',
        'wash'            => 'غسيل وتلميع',
        'mechanical'      => 'صيانة ميكانيكية',
        'body_paint'      => 'إصلاح سمكرة ودهان',
        'year'            => 'سنة الصنع',
        'make'            => 'الشركة المصنعة',
        'model'           => 'الموديل',
        'problem'         => 'وصف المشكلة',
        'name'            => 'اسمك الكامل',
        'phone'           => 'رقم الهاتف',
        'date'            => 'التاريخ المفضل',
        'time'            => 'الوقت المفضل',
        'next'            => 'التالي',
        'prev'            => 'السابق',
        'submit'          => 'تأكيد الحجز',
    ],
    'en' => [
        'page_title'      => 'Smart Booking Wizard',
        'step_1_title'    => 'Select Service',
        'step_1_desc'     => 'What service do you need?',
        'step_2_title'    => 'Car Details',
        'step_2_desc'     => 'Tell us about your car',
        'step_3_title'    => 'Problem Description',
        'step_3_desc'     => 'What problem are you facing?',
        'step_4_title'    => 'Contact Information',
        'step_4_desc'     => 'Complete your personal information',
        'wash'            => 'Wash & Polish',
        'mechanical'      => 'Mechanical Repair',
        'body_paint'      => 'Body & Paint Repair',
        'year'            => 'Year',
        'make'            => 'Make',
        'model'           => 'Model',
        'problem'         => 'Problem Description',
        'name'            => 'Full Name',
        'phone'           => 'Phone Number',
        'date'            => 'Preferred Date',
        'time'            => 'Preferred Time',
        'next'            => 'Next',
        'prev'            => 'Previous',
        'submit'          => 'Confirm Booking',
    ]
];

$t = $wizard_content[$current_lang];
?>

<!-- Page Header -->
<section style="padding: 3rem 2rem; background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%); text-align: center;">
    <div class="container">
        <h1 style="color: var(--accent-cyan); font-size: 2.5rem; text-shadow: 0 0 10px var(--accent-cyan); margin-bottom: 0.5rem;">
            <?php echo $t['page_title']; ?>
        </h1>
        <p style="color: var(--text-muted); font-size: 1.1rem;">
            <?php echo $is_rtl ? 'احجز خدمتك في 4 خطوات بسيطة' : 'Book your service in 4 simple steps'; ?>
        </p>
    </div>
</section>

<!-- Wizard Container -->
<div class="wizard-container">
    <!-- Progress Bar -->
    <div class="wizard-progress">
        <div class="progress-step active" style="width: 40px; height: 40px; border-radius: 50%; background: var(--accent-cyan); border: 2px solid var(--accent-cyan); display: flex; align-items: center; justify-content: center; color: var(--primary-dark); font-weight: 700; box-shadow: 0 0 20px var(--accent-cyan);">1</div>
        <div class="progress-step" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(0, 255, 255, 0.1); border: 2px solid var(--border-glow); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-weight: 700;">2</div>
        <div class="progress-step" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(0, 255, 255, 0.1); border: 2px solid var(--border-glow); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-weight: 700;">3</div>
        <div class="progress-step" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(0, 255, 255, 0.1); border: 2px solid var(--border-glow); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-weight: 700;">4</div>
    </div>
    
    <!-- Wizard Form -->
    <form id="wizardForm">
        <!-- Step 1: Service Selection -->
        <div id="step-1" class="wizard-step active">
            <h2><?php echo $t['step_1_title']; ?></h2>
            <p style="color: var(--text-muted); margin-bottom: 2rem;"><?php echo $t['step_1_desc']; ?></p>
            
            <div class="service-icons">
                <button type="button" class="service-icon-btn" data-service="wash">
                    <i class="fas fa-droplet"></i>
                    <div><?php echo $t['wash']; ?></div>
                </button>
                <button type="button" class="service-icon-btn" data-service="mechanical">
                    <i class="fas fa-wrench"></i>
                    <div><?php echo $t['mechanical']; ?></div>
                </button>
                <button type="button" class="service-icon-btn" data-service="body_paint">
                    <i class="fas fa-spray-can"></i>
                    <div><?php echo $t['body_paint']; ?></div>
                </button>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                <button type="button" class="btn-neon btn-next">
                    <?php echo $t['next']; ?> <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Step 2: Car Details -->
        <div id="step-2" class="wizard-step">
            <h2><?php echo $t['step_2_title']; ?></h2>
            <p style="color: var(--text-muted); margin-bottom: 2rem;"><?php echo $t['step_2_desc']; ?></p>
            
            <div class="form-group">
                <label><?php echo $t['year']; ?></label>
                <select id="carYear" onchange="PulseForge.loadCarModels('make', this.value)" required>
                    <option value="">-- <?php echo $is_rtl ? 'اختر السنة' : 'Select Year'; ?> --</option>
                    <?php for ($year = date('Y'); $year >= 2000; $year--): ?>
                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label><?php echo $t['make']; ?></label>
                <select id="carMake" onchange="PulseForge.loadCarModels('model', this.value)" required>
                    <option value="">-- <?php echo $is_rtl ? 'اختر الشركة' : 'Select Make'; ?> --</option>
                    <option value="Tesla">Tesla</option>
                    <option value="BMW">BMW</option>
                    <option value="Mercedes-Benz">Mercedes-Benz</option>
                    <option value="Toyota">Toyota</option>
                    <option value="Honda">Honda</option>
                    <option value="Audi">Audi</option>
                </select>
            </div>
            
            <div class="form-group">
                <label><?php echo $t['model']; ?></label>
                <select id="carModel" required>
                    <option value="">-- <?php echo $is_rtl ? 'اختر الموديل' : 'Select Model'; ?> --</option>
                </select>
            </div>
            
            <div style="display: flex; justify-content: space-between; gap: 1rem; margin-top: 2rem;">
                <button type="button" class="btn-neon btn-prev" style="border-color: var(--accent-orange); color: var(--accent-orange);">
                    <i class="fas fa-arrow-left"></i> <?php echo $t['prev']; ?>
                </button>
                <button type="button" class="btn-neon btn-next">
                    <?php echo $t['next']; ?> <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Step 3: Problem Description -->
        <div id="step-3" class="wizard-step">
            <h2><?php echo $t['step_3_title']; ?></h2>
            <p style="color: var(--text-muted); margin-bottom: 2rem;"><?php echo $t['step_3_desc']; ?></p>
            
            <div class="form-group">
                <label><?php echo $t['problem']; ?></label>
                <textarea id="problemDescription" placeholder="<?php echo $is_rtl ? 'صف المشكلة بالتفصيل...' : 'Describe the problem in detail...'; ?>" required></textarea>
            </div>
            
            <div style="display: flex; justify-content: space-between; gap: 1rem; margin-top: 2rem;">
                <button type="button" class="btn-neon btn-prev" style="border-color: var(--accent-orange); color: var(--accent-orange);">
                    <i class="fas fa-arrow-left"></i> <?php echo $t['prev']; ?>
                </button>
                <button type="button" class="btn-neon btn-next">
                    <?php echo $t['next']; ?> <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Step 4: Contact Information -->
        <div id="step-4" class="wizard-step">
            <h2><?php echo $t['step_4_title']; ?></h2>
            <p style="color: var(--text-muted); margin-bottom: 2rem;"><?php echo $t['step_4_desc']; ?></p>
            
            <div class="form-group">
                <label><?php echo $t['name']; ?></label>
                <input type="text" id="customerName" placeholder="<?php echo $is_rtl ? 'أحمد محمد' : 'John Doe'; ?>" required>
            </div>
            
            <div class="form-group">
                <label><?php echo $t['phone']; ?></label>
                <input type="tel" id="customerPhone" placeholder="<?php echo $is_rtl ? '+966501234567' : '+1234567890'; ?>" required>
            </div>
            
            <div class="form-group">
                <label><?php echo $t['date']; ?></label>
                <input type="date" id="preferredDate" required>
            </div>
            
            <div class="form-group">
                <label><?php echo $t['time']; ?></label>
                <input type="time" id="preferredTime" required>
            </div>
            
            <div style="display: flex; justify-content: space-between; gap: 1rem; margin-top: 2rem;">
                <button type="button" class="btn-neon btn-prev" style="border-color: var(--accent-orange); color: var(--accent-orange);">
                    <i class="fas fa-arrow-left"></i> <?php echo $t['prev']; ?>
                </button>
                <button type="button" id="submitBtn" class="btn-neon" style="border-color: #00ff00; color: #00ff00;">
                    <i class="fas fa-check"></i> <?php echo $t['submit']; ?>
                </button>
            </div>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
