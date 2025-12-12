<?php
/**
 * PulseForge Auto Service - Track Status Page
 * صفحة متابعة حالة السيارة
 */

include '../includes/header.php';
include '../includes/functions.php';

$is_rtl = ($current_lang === 'ar');

// Localized content
$track_content = [
    'ar' => [
        'page_title'      => 'تتبع حالة سيارتك',
        'tracking_code'   => 'كود المتابعة',
        'search'          => 'ابحث',
        'no_booking'      => 'لم نجد حجزاً بهذا الكود',
        'customer_name'   => 'اسم العميل',
        'service'         => 'الخدمة',
        'car'             => 'السيارة',
        'status'          => 'الحالة',
        'date'            => 'التاريخ',
        'time'            => 'الوقت',
        'problem'         => 'المشكلة',
        'timeline'        => 'مسار التقدم',
        'pending'         => 'قيد الانتظار',
        'received'        => 'تم الاستقبال',
        'in_service'      => 'قيد الصيانة',
        'ready'           => 'جاهزة للاستلام',
        'completed'       => 'مكتملة',
    ],
    'en' => [
        'page_title'      => 'Track Your Car Status',
        'tracking_code'   => 'Tracking Code',
        'search'          => 'Search',
        'no_booking'      => 'No booking found with this code',
        'customer_name'   => 'Customer Name',
        'service'         => 'Service',
        'car'             => 'Car',
        'status'          => 'Status',
        'date'            => 'Date',
        'time'            => 'Time',
        'problem'         => 'Problem',
        'timeline'        => 'Progress Timeline',
        'pending'         => 'Pending',
        'received'        => 'Received',
        'in_service'      => 'In Service',
        'ready'           => 'Ready for Pickup',
        'completed'       => 'Completed',
    ]
];

$t = $track_content[$current_lang];

// Simulate booking data (في التطبيق الحقيقي، سيتم جلب البيانات من قاعدة البيانات)
$sample_booking = [
    'tracking_code' => 'ABC1234',
    'customer_name' => $is_rtl ? 'أحمد محمد' : 'Ahmed Mohammed',
    'service' => $is_rtl ? 'صيانة ميكانيكية' : 'Mechanical Repair',
    'car' => '2023 BMW X5',
    'status' => 'IN_SERVICE',
    'date' => '2024-12-15',
    'time' => '10:30',
    'problem' => $is_rtl ? 'صوت غريب من المحرك' : 'Strange noise from engine',
];
?>

<!-- Page Header -->
<section style="padding: 3rem 2rem; background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%); text-align: center;">
    <div class="container">
        <h1 style="color: var(--accent-cyan); font-size: 2.5rem; text-shadow: 0 0 10px var(--accent-cyan); margin-bottom: 0.5rem;">
            <?php echo $t['page_title']; ?>
        </h1>
        <p style="color: var(--text-muted); font-size: 1.1rem;">
            <?php echo $is_rtl ? 'أدخل كود المتابعة لرؤية حالة سيارتك' : 'Enter your tracking code to see your car status'; ?>
        </p>
    </div>
</section>

<!-- Search Section -->
<section style="padding: 2rem; background: linear-gradient(135deg, var(--secondary-dark) 0%, var(--primary-dark) 100%);">
    <div class="container" style="max-width: 600px;">
        <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
            <input type="text" id="trackingCodeInput" placeholder="<?php echo $is_rtl ? 'مثال: ABC1234' : 'e.g., ABC1234'; ?>" 
                   style="flex: 1; padding: 12px; background: rgba(0, 0, 0, 0.3); border: 1px solid var(--border-glow); border-radius: 5px; color: var(--text-light);">
            <button onclick="searchBooking()" class="btn-neon">
                <i class="fas fa-search"></i> <?php echo $t['search']; ?>
            </button>
        </div>
        
        <!-- Demo Note -->
        <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center;">
            <?php echo $is_rtl ? '💡 جرّب: ABC1234' : '💡 Try: ABC1234'; ?>
        </p>
    </div>
</section>

<!-- Booking Details Section -->
<section style="padding: 3rem 2rem;">
    <div class="container" style="max-width: 900px;">
        <!-- Booking Info Card -->
        <div id="bookingCard" style="display: none; background: linear-gradient(135deg, rgba(0, 255, 255, 0.05) 0%, rgba(255, 107, 53, 0.05) 100%); border: 1px solid var(--border-glow); border-radius: 10px; padding: 2rem; margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <div>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;"><?php echo $t['customer_name']; ?></p>
                    <p id="bookingName" style="color: var(--accent-cyan); font-weight: 700; font-size: 1.1rem;"></p>
                </div>
                <div>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;"><?php echo $t['service']; ?></p>
                    <p id="bookingService" style="color: var(--accent-cyan); font-weight: 700; font-size: 1.1rem;"></p>
                </div>
                <div>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;"><?php echo $t['car']; ?></p>
                    <p id="bookingCar" style="color: var(--accent-cyan); font-weight: 700; font-size: 1.1rem;"></p>
                </div>
            </div>
            
            <hr style="border-color: var(--border-glow); margin: 2rem 0;">
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;"><?php echo $t['date']; ?></p>
                    <p id="bookingDate" style="color: var(--accent-orange); font-weight: 700; font-size: 1.1rem;"></p>
                </div>
                <div>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;"><?php echo $t['time']; ?></p>
                    <p id="bookingTime" style="color: var(--accent-orange); font-weight: 700; font-size: 1.1rem;"></p>
                </div>
                <div>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;"><?php echo $t['status']; ?></p>
                    <p id="bookingStatus" style="color: var(--accent-cyan); font-weight: 700; font-size: 1.1rem;"></p>
                </div>
            </div>
            
            <div style="margin-top: 1.5rem;">
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;"><?php echo $t['problem']; ?></p>
                <p id="bookingProblem" style="color: var(--text-light); font-size: 1rem; line-height: 1.6;"></p>
            </div>
        </div>
        
        <!-- Status Timeline -->
        <div id="timelineCard" style="display: none;">
            <h2 style="color: var(--accent-cyan); margin-bottom: 2rem; text-shadow: 0 0 10px var(--accent-cyan);">
                <?php echo $t['timeline']; ?>
            </h2>
            
            <div class="status-tracker">
                <div class="status-timeline">
                    <!-- Status Item 1: Pending -->
                    <div class="status-item" id="status-PENDING">
                        <div class="status-dot"></div>
                        <div class="status-content">
                            <h4><?php echo $t['pending']; ?></h4>
                            <p><?php echo $is_rtl ? 'انتظار تأكيد الموعد' : 'Waiting for appointment confirmation'; ?></p>
                        </div>
                    </div>
                    
                    <!-- Status Item 2: Received -->
                    <div class="status-item" id="status-RECEIVED">
                        <div class="status-dot"></div>
                        <div class="status-content">
                            <h4><?php echo $t['received']; ?></h4>
                            <p><?php echo $is_rtl ? 'تم استقبال سيارتك بنجاح' : 'Your car has been received successfully'; ?></p>
                        </div>
                    </div>
                    
                    <!-- Status Item 3: In Service -->
                    <div class="status-item" id="status-IN_SERVICE">
                        <div class="status-dot"></div>
                        <div class="status-content">
                            <h4><?php echo $t['in_service']; ?></h4>
                            <p><?php echo $is_rtl ? 'جاري العمل على سيارتك الآن' : 'We are working on your car now'; ?></p>
                        </div>
                    </div>
                    
                    <!-- Status Item 4: Ready -->
                    <div class="status-item" id="status-READY">
                        <div class="status-dot"></div>
                        <div class="status-content">
                            <h4><?php echo $t['ready']; ?></h4>
                            <p><?php echo $is_rtl ? 'سيارتك جاهزة للاستلام' : 'Your car is ready for pickup'; ?></p>
                        </div>
                    </div>
                    
                    <!-- Status Item 5: Completed -->
                    <div class="status-item" id="status-COMPLETED">
                        <div class="status-dot"></div>
                        <div class="status-content">
                            <h4><?php echo $t['completed']; ?></h4>
                            <p><?php echo $is_rtl ? 'تم إكمال الخدمة بنجاح' : 'Service completed successfully'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- No Booking Message -->
        <div id="noBookingMessage" style="text-align: center; padding: 3rem; color: var(--text-muted);">
            <i class="fas fa-search" style="font-size: 3rem; color: var(--accent-orange); margin-bottom: 1rem; display: block;"></i>
            <p style="font-size: 1.1rem;">
                <?php echo $is_rtl ? 'أدخل كود المتابعة للبحث عن حالة سيارتك' : 'Enter your tracking code to search for your car status'; ?>
            </p>
        </div>
    </div>
</section>

<script>
    /**
     * Search for booking by tracking code
     * البحث عن الحجز باستخدام كود المتابعة
     */
    function searchBooking() {
        const trackingCode = document.getElementById('trackingCodeInput').value.trim().toUpperCase();
        
        if (!trackingCode) {
            alert('<?php echo $is_rtl ? 'يرجى إدخال كود المتابعة' : 'Please enter tracking code'; ?>');
            return;
        }
        
        // Demo: Use sample data if code is ABC1234
        if (trackingCode === 'ABC1234') {
            displayBooking({
                tracking_code: 'ABC1234',
                customer_name: '<?php echo $is_rtl ? 'أحمد محمد' : 'Ahmed Mohammed'; ?>',
                service: '<?php echo $is_rtl ? 'صيانة ميكانيكية' : 'Mechanical Repair'; ?>',
                car: '2023 BMW X5',
                status: 'IN_SERVICE',
                date: '2024-12-15',
                time: '10:30',
                problem: '<?php echo $is_rtl ? 'صوت غريب من المحرك' : 'Strange noise from engine'; ?>'
            });
        } else {
            // In real app, fetch from API
            document.getElementById('bookingCard').style.display = 'none';
            document.getElementById('timelineCard').style.display = 'none';
            document.getElementById('noBookingMessage').innerHTML = `
                <i class="fas fa-exclamation-circle" style="font-size: 3rem; color: var(--accent-orange); margin-bottom: 1rem; display: block;"></i>
                <p style="font-size: 1.1rem; color: var(--accent-orange);">
                    <?php echo $t['no_booking']; ?>
                </p>
            `;
        }
    }
    
    /**
     * Display booking information
     * عرض معلومات الحجز
     */
    function displayBooking(booking) {
        // Hide no booking message
        document.getElementById('noBookingMessage').style.display = 'none';
        
        // Show booking card
        document.getElementById('bookingCard').style.display = 'block';
        document.getElementById('bookingName').textContent = booking.customer_name;
        document.getElementById('bookingService').textContent = booking.service;
        document.getElementById('bookingCar').textContent = booking.car;
        document.getElementById('bookingDate').textContent = booking.date;
        document.getElementById('bookingTime').textContent = booking.time;
        document.getElementById('bookingStatus').textContent = getStatusText(booking.status);
        document.getElementById('bookingProblem').textContent = booking.problem;
        
        // Show timeline
        document.getElementById('timelineCard').style.display = 'block';
        
        // Update timeline based on status
        updateTimeline(booking.status);
        
        // Scroll to results
        document.getElementById('bookingCard').scrollIntoView({ behavior: 'smooth' });
    }
    
    /**
     * Get status text in current language
     * الحصول على نص الحالة باللغة الحالية
     */
    function getStatusText(status) {
        const statuses = {
            'PENDING': '<?php echo $t['pending']; ?>',
            'RECEIVED': '<?php echo $t['received']; ?>',
            'IN_SERVICE': '<?php echo $t['in_service']; ?>',
            'READY': '<?php echo $t['ready']; ?>',
            'COMPLETED': '<?php echo $t['completed']; ?>'
        };
        return statuses[status] || 'Unknown';
    }
    
    /**
     * Update timeline based on current status
     * تحديث Timeline بناءً على الحالة الحالية
     */
    function updateTimeline(currentStatus) {
        const statuses = ['PENDING', 'RECEIVED', 'IN_SERVICE', 'READY', 'COMPLETED'];
        const currentIndex = statuses.indexOf(currentStatus);
        
        statuses.forEach((status, index) => {
            const statusItem = document.getElementById(`status-${status}`);
            if (statusItem) {
                if (index < currentIndex) {
                    statusItem.classList.add('completed');
                    statusItem.classList.remove('active');
                } else if (index === currentIndex) {
                    statusItem.classList.add('active');
                    statusItem.classList.remove('completed');
                } else {
                    statusItem.classList.remove('active', 'completed');
                }
            }
        });
    }
    
    // Allow Enter key to search
    document.getElementById('trackingCodeInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchBooking();
        }
    });
</script>

<?php include '../includes/footer.php'; ?>
