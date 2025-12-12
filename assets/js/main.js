/**
 * PulseForge Auto Service - Main JavaScript File
 * ملف JavaScript الرئيسي - منطق نظام الحجز الذكي والأنميشنات
 */

// ===== Wizard State Management =====
let wizardState = {
    currentStep: 1,
    totalSteps: 4,
    data: {
        service: null,
        year: null,
        make: null,
        model: null,
        problem: null,
        date: null,
        time: null,
        name: null,
        phone: null
    }
};

// ===== Initialize Wizard =====
document.addEventListener('DOMContentLoaded', function() {
    initializeWizard();
    setupParallaxEffect();
    setupScrollAnimations();
    setupFormValidation();
});

function initializeWizard() {
    const wizardForm = document.getElementById('wizardForm');
    if (!wizardForm) return;
    
    // Event listeners for service selection
    const serviceButtons = document.querySelectorAll('.service-icon-btn');
    serviceButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            selectService(this);
        });
    });
    
    // Event listeners for next/prev buttons
    const nextButtons = document.querySelectorAll('.btn-next');
    const prevButtons = document.querySelectorAll('.btn-prev');
    
    nextButtons.forEach(btn => {
        btn.addEventListener('click', nextStep);
    });
    
    prevButtons.forEach(btn => {
        btn.addEventListener('click', prevStep);
    });
    
    // Form submission
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.addEventListener('click', submitBooking);
    }
}

/**
 * Select Service Handler
 * تحديد نوع الخدمة المطلوبة
 */
function selectService(element) {
    // Remove active class from all buttons
    document.querySelectorAll('.service-icon-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Add active class to clicked button
    element.classList.add('active');
    
    // Store selected service
    wizardState.data.service = element.getAttribute('data-service');
    
    // Add animation
    element.style.animation = 'none';
    setTimeout(() => {
        element.style.animation = '';
    }, 10);
}

/**
 * Next Step Handler
 * الانتقال للخطوة التالية
 */
function nextStep() {
    // Validate current step
    if (!validateStep(wizardState.currentStep)) {
        showError('يرجى ملء جميع الحقول المطلوبة');
        return;
    }
    
    if (wizardState.currentStep < wizardState.totalSteps) {
        // Hide current step
        const currentStepEl = document.getElementById(`step-${wizardState.currentStep}`);
        if (currentStepEl) {
            currentStepEl.classList.remove('active');
        }
        
        // Update step
        wizardState.currentStep++;
        
        // Show next step
        const nextStepEl = document.getElementById(`step-${wizardState.currentStep}`);
        if (nextStepEl) {
            nextStepEl.classList.add('active');
        }
        
        // Update progress bar
        updateProgressBar();
        
        // Scroll to top
        document.querySelector('.wizard-container').scrollIntoView({ behavior: 'smooth' });
    }
}

/**
 * Previous Step Handler
 * العودة للخطوة السابقة
 */
function prevStep() {
    if (wizardState.currentStep > 1) {
        // Hide current step
        const currentStepEl = document.getElementById(`step-${wizardState.currentStep}`);
        if (currentStepEl) {
            currentStepEl.classList.remove('active');
        }
        
        // Update step
        wizardState.currentStep--;
        
        // Show previous step
        const prevStepEl = document.getElementById(`step-${wizardState.currentStep}`);
        if (prevStepEl) {
            prevStepEl.classList.add('active');
        }
        
        // Update progress bar
        updateProgressBar();
        
        // Scroll to top
        document.querySelector('.wizard-container').scrollIntoView({ behavior: 'smooth' });
    }
}

/**
 * Validate Step
 * التحقق من صحة الخطوة الحالية
 */
function validateStep(step) {
    switch(step) {
        case 1:
            // Check if service is selected
            return wizardState.data.service !== null;
        
        case 2:
            // Check if car model is selected
            return wizardState.data.year && wizardState.data.make && wizardState.data.model;
        
        case 3:
            // Check if problem description is filled
            const problemInput = document.getElementById('problemDescription');
            return problemInput && problemInput.value.trim().length > 0;
        
        case 4:
            // Check if all contact info is filled
            const nameInput = document.getElementById('customerName');
            const phoneInput = document.getElementById('customerPhone');
            const dateInput = document.getElementById('preferredDate');
            const timeInput = document.getElementById('preferredTime');
            
            return nameInput && nameInput.value.trim().length > 0 &&
                   phoneInput && phoneInput.value.trim().length > 0 &&
                   dateInput && dateInput.value &&
                   timeInput && timeInput.value;
        
        default:
            return true;
    }
}

/**
 * Update Progress Bar
 * تحديث شريط التقدم
 */
function updateProgressBar() {
    const progressSteps = document.querySelectorAll('.progress-step');
    
    progressSteps.forEach((step, index) => {
        const stepNum = index + 1;
        
        if (stepNum < wizardState.currentStep) {
            step.classList.add('completed');
            step.classList.remove('active');
        } else if (stepNum === wizardState.currentStep) {
            step.classList.add('active');
            step.classList.remove('completed');
        } else {
            step.classList.remove('active', 'completed');
        }
    });
}

/**
 * Submit Booking
 * إرسال الحجز
 */
function submitBooking() {
    // Collect all form data
    wizardState.data.name = document.getElementById('customerName')?.value;
    wizardState.data.phone = document.getElementById('customerPhone')?.value;
    wizardState.data.date = document.getElementById('preferredDate')?.value;
    wizardState.data.time = document.getElementById('preferredTime')?.value;
    
    // Validate all data
    if (!validateStep(4)) {
        showError('يرجى ملء جميع الحقول المطلوبة');
        return;
    }
    
    // Send booking via AJAX
    fetch('/api/submit_booking.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(wizardState.data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess(`تم إنشاء الحجز بنجاح! كود المتابعة: ${data.tracking_code}`);
            // Reset form after 2 seconds
            setTimeout(() => {
                resetWizard();
            }, 2000);
        } else {
            showError(data.message || 'حدث خطأ أثناء إنشاء الحجز');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('حدث خطأ في الاتصال بالخادم');
    });
}

/**
 * Reset Wizard
 * إعادة تعيين نموذج الحجز
 */
function resetWizard() {
    wizardState.currentStep = 1;
    wizardState.data = {
        service: null,
        year: null,
        make: null,
        model: null,
        problem: null,
        date: null,
        time: null,
        name: null,
        phone: null
    };
    
    // Reset UI
    document.querySelectorAll('.wizard-step').forEach(step => {
        step.classList.remove('active');
    });
    document.getElementById('step-1')?.classList.add('active');
    
    document.querySelectorAll('.service-icon-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    updateProgressBar();
}

/**
 * Show Error Message
 * عرض رسالة خطأ
 */
function showError(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger';
    alertDiv.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        left: 20px;
        padding: 1rem;
        background: rgba(255, 107, 53, 0.1);
        border: 2px solid #ff6b35;
        border-radius: 5px;
        color: #ff6b35;
        z-index: 1000;
        animation: slideInDown 0.5s ease-out;
    `;
    alertDiv.textContent = message;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

/**
 * Show Success Message
 * عرض رسالة نجاح
 */
function showSuccess(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success';
    alertDiv.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        left: 20px;
        padding: 1rem;
        background: rgba(0, 255, 0, 0.1);
        border: 2px solid #00ff00;
        border-radius: 5px;
        color: #00ff00;
        z-index: 1000;
        animation: slideInDown 0.5s ease-out;
    `;
    alertDiv.textContent = message;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

/**
 * Setup Parallax Effect
 * تأثير المنظور عند التمرير
 */
function setupParallaxEffect() {
    const parallaxBgs = document.querySelectorAll('.parallax-bg');
    
    if (parallaxBgs.length === 0) return;
    
    window.addEventListener('scroll', () => {
        parallaxBgs.forEach(bg => {
            const scrollPosition = window.pageYOffset;
            bg.style.transform = `translateY(${scrollPosition * 0.5}px)`;
        });
    });
}

/**
 * Setup Scroll Animations (using AOS)
 * تأثيرات الظهور عند التمرير
 */
function setupScrollAnimations() {
    // AOS library is loaded from CDN
    // Just ensure it's initialized
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    }
}

/**
 * Setup Form Validation
 * التحقق من صحة النموذج
 */
function setupFormValidation() {
    const phoneInput = document.getElementById('customerPhone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            // Allow only numbers
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
    
    const dateInput = document.getElementById('preferredDate');
    if (dateInput) {
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
    }
}

/**
 * Load Car Models via AJAX
 * تحميل موديلات السيارات ديناميكياً
 */
function loadCarModels(type, value) {
    const url = `/api/get_car_models.php?type=${type}&value=${value}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateSelect(type, data.models);
            }
        })
        .catch(error => console.error('Error loading car models:', error));
}

/**
 * Populate Select Element
 * ملء عنصر قائمة منسدلة
 */
function populateSelect(selectId, options) {
    const select = document.getElementById(selectId);
    if (!select) return;
    
    // Clear existing options (except first one)
    while (select.options.length > 1) {
        select.remove(1);
    }
    
    // Add new options
    options.forEach(option => {
        const opt = document.createElement('option');
        opt.value = option.value;
        opt.textContent = option.text;
        select.appendChild(opt);
    });
}

/**
 * Typewriter Effect for Hero Text
 * تأثير الكتابة للنصوص الرئيسية
 */
function typewriterEffect(element, text, speed = 50) {
    if (!element) return;
    
    let index = 0;
    element.textContent = '';
    
    function type() {
        if (index < text.length) {
            element.textContent += text.charAt(index);
            index++;
            setTimeout(type, speed);
        }
    }
    
    type();
}

// ===== Export for use in other files =====
window.PulseForge = {
    wizardState,
    nextStep,
    prevStep,
    submitBooking,
    selectService,
    loadCarModels,
    typewriterEffect
};
