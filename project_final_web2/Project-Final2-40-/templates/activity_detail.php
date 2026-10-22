<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดกิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background-color: #f3f4f6;
            background-image:
                radial-gradient(circle at 15% 50%, rgba(139, 92, 246, 0.2), transparent 30%),
                radial-gradient(circle at 85% 30%, rgba(99, 102, 241, 0.2), transparent 30%),
                linear-gradient(to right, rgba(200, 200, 200, 0.3) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(200, 200, 200, 0.3) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 40px 40px, 40px 40px;
            background-attachment: fixed;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="min-h-screen p-4 md:p-8">

    <div class="max-w-4xl mx-auto mt-4">

        <nav class="mb-8">
            <a href="dashboard" class="inline-flex items-center text-slate-500 font-bold bg-white px-6 py-3 rounded-full shadow-sm border border-slate-100 hover:text-purple-600 hover:border-purple-200 transition">
                <span class="mr-2">⬅️</span> กลับแดชบอร์ด
            </a>
        </nav>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">

            <?php
            $event_id = $activity['EventID'];
            $folder_path = "uploads/event_" . $event_id . "/";
            $server_dir = BASE_PATH . "/public/" . $folder_path;
            $images = [];
            if (is_dir($server_dir)) {
                $images = glob($server_dir . "*.{jpg,jpeg,png,gif,webp,JPG,JPEG,PNG,GIF,WEBP}", GLOB_BRACE);
            }
            ?>

            <?php if (count($images) > 0): ?>
                <div class="w-full bg-slate-900 relative group rounded-t-[2.5rem] overflow-hidden">
                    <div id="carousel-detail-<?php echo $event_id; ?>" class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar h-80 md:h-[400px] scroll-smooth">
                        <?php foreach ($images as $img_path): $web_path = $folder_path . basename($img_path); ?>
                            <div class="w-full h-full flex-shrink-0 snap-center relative">
                                <img src="<?php echo htmlspecialchars($web_path); ?>" class="w-full h-full object-cover opacity-90">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (count($images) > 1): ?>
                        <button onclick="scrollCarouselDetail('carousel-detail-<?php echo $event_id; ?>', -1)" type="button" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/80 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all z-10 shadow-lg text-2xl">&#10094;</button>

                        <button onclick="scrollCarouselDetail('carousel-detail-<?php echo $event_id; ?>', 1)" type="button" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/80 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all z-10 shadow-lg text-2xl">&#10095;</button>

                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10 bg-black/40 px-4 py-2 rounded-full backdrop-blur-sm">
                            <?php for ($i = 0; $i < count($images); $i++): ?>
                                <div class="w-2.5 h-2.5 rounded-full bg-white/80 shadow-sm"></div>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="w-full h-80 md:h-[400px] bg-gradient-to-br from-slate-50 to-slate-200 relative rounded-t-[2.5rem] flex flex-col items-center justify-center text-slate-400 border-b border-slate-100">
                    <span class="text-6xl mb-4 opacity-50">🖼️</span>
                    <p class="font-bold text-lg">ไม่มีรูปภาพประกอบ</p>
                </div>
            <?php endif; ?>

            <div class="p-8 md:p-12 relative">

                <div id="badge_status" class="absolute -top-6 right-8 px-6 py-2.5 rounded-full font-black text-sm shadow-xl backdrop-blur-md border 
                <?php
                $status = strtolower($activity['Status']);
                if ($status == 'checked_in') echo 'bg-blue-500 text-white border-blue-400';
                elseif ($status == 'approved') echo 'bg-green-500 text-white border-green-400';
                elseif ($status == 'rejected' || $status == 'rejected_hidden') echo 'bg-red-500 text-white border-red-400';
                else echo 'bg-yellow-400 text-yellow-900 border-yellow-300';
                ?>">
                    <?php
                    if ($status == 'checked_in') echo '✨ เข้าร่วมสำเร็จ';
                    elseif ($status == 'approved') echo '✅ อนุมัติแล้ว';
                    elseif ($status == 'rejected' || $status == 'rejected_hidden') echo '❌ ถูกปฏิเสธ';
                    else echo '⏳ รอการอนุมัติ';
                    ?>
                </div>

                <h1 class="text-4xl md:text-5xl font-black text-slate-800 mb-4 break-all tracking-tight leading-tight mt-4"><?php echo htmlspecialchars($activity['Title']); ?></h1>
                <p class="text-lg text-slate-500 font-medium break-all mb-10">จัดโดย: <span class="text-purple-600 font-bold"><?php echo htmlspecialchars($activity['creator_name']); ?></span></p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 flex items-center gap-4">
                        <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-2xl shadow-sm border border-slate-100">📅</div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">เริ่มต้น</p>
                            <p class="text-xl font-black text-slate-800"><?php echo date('d M Y - H:i', strtotime($activity['StartDate'])); ?> น.</p>
                        </div>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 flex items-center gap-4">
                        <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-2xl shadow-sm border border-slate-100">⏳</div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">สิ้นสุด</p>
                            <p class="text-xl font-black text-slate-800"><?php echo date('d M Y - H:i', strtotime($activity['EndDate'])); ?> น.</p>
                        </div>
                    </div>
                </div>

                <div class="prose prose-lg max-w-none text-slate-600 mb-12 leading-relaxed font-medium">
                    <h3 class="text-slate-800 font-black text-2xl mb-4">รายละเอียดกิจกรรม</h3>
                    <div class="break-all whitespace-pre-wrap bg-slate-50 p-8 rounded-[2rem] border border-slate-100"><?php echo nl2br(htmlspecialchars($activity['Desciption'])); ?></div>
                </div>

                <div class="border-t-2 border-dashed border-slate-200 pt-12 text-center">
                    <?php
                    date_default_timezone_set('Asia/Bangkok');
                    $is_ended = (time() > strtotime($activity['EndDate']));
                    ?>

                    <div id="success_checked_in" class="hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-10 rounded-[2.5rem] shadow-xl text-white">
                            <span class="text-6xl block mb-4">🎉</span>
                            <h3 class="text-3xl font-black mb-2">เข้าร่วมกิจกรรมสำเร็จ!</h3>
                            <p class="font-medium text-blue-100 text-lg">ขอบคุณที่มาร่วมสร้างประสบการณ์ดีๆ ด้วยกัน</p>
                        </div>
                    </div>

                    <div id="waiting_otp">
                        <?php if ($status == 'rejected' || $status == 'rejected_hidden'): ?>
                            <div class="bg-red-50 p-8 rounded-3xl border border-red-200 text-red-500 font-bold mb-6">
                                <span class="text-4xl block mb-3">❌</span> คำขอเข้าร่วมกิจกรรมของคุณถูกปฏิเสธ
                            </div>
                            <button onclick="confirmLeaveActivity()" class="w-full bg-white text-purple-600 font-bold py-4 rounded-xl border border-purple-200 shadow-sm hover:bg-purple-50 transition">
                                🔄 ขอเข้าร่วมใหม่อีกครั้ง
                            </button>
                        <?php elseif ($is_ended && $status != 'checked_in'): ?>
                            <div class="bg-slate-100 p-8 rounded-3xl border border-slate-200 text-slate-400 font-bold">
                                <span class="text-4xl block mb-2">⛔</span> กิจกรรมนี้สิ้นสุดลงแล้ว
                            </div>
                        <?php elseif ($status == 'approved' || $status == 'checked_in'): ?>
                            <?php $isStarted = time() >= strtotime($activity['StartDate']); ?>

                            <div class="bg-white p-8 md:p-10 rounded-[2.5rem] border border-slate-200 shadow-xl max-w-lg mx-auto relative overflow-hidden">
                                <div class="absolute -top-10 -right-10 w-32 h-32 bg-purple-100 rounded-full blur-2xl"></div>

                                <h4 class="text-2xl font-black text-slate-800 mb-6 relative z-10">🎫 ยืนยันการเข้างาน</h4>

                                <div class="flex flex-col gap-5 relative z-10">
                                    <?php if ($isStarted): ?>
                                        <button type="button" onclick="generateOTP()" class="w-full bg-slate-900 text-white font-bold py-4 rounded-full shadow-lg hover:bg-purple-600 transition flex items-center justify-center gap-2">
                                            🔑 ขอรับรหัส OTP
                                        </button>
                                    <?php else: ?>
                                        <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl text-slate-500 font-bold">
                                            ⏳ กรุณารอเวลาเริ่มกิจกรรมเพื่อรับ OTP
                                        </div>
                                    <?php endif; ?>

                                    <div class="relative">
                                        <input type="text" id="input_verify_otp" maxlength="6" placeholder="000000"
                                            class="w-full text-center text-4xl font-black tracking-[0.3em] py-6 bg-slate-50 border-2 border-slate-200 rounded-[2rem] focus:border-purple-500 focus:bg-white focus:ring-4 focus:ring-purple-500/20 outline-none transition shadow-inner text-slate-800">
                                    </div>

                                    <button type="button" onclick="verifyOTP()" class="w-full bg-purple-600 text-white font-black py-4 rounded-full hover:bg-purple-700 transition shadow-lg shadow-purple-200 text-lg active:scale-95">
                                        ยืนยันรหัส
                                    </button>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 text-slate-500 font-bold mb-6">
                                <span class="text-4xl block mb-3">⏳</span> รอการอนุมัติจากผู้จัดกิจกรรม
                            </div>
                            <button onclick="confirmLeaveActivity()" class="w-full bg-white text-red-500 font-bold py-4 rounded-xl hover:bg-red-50 hover:border-red-200 transition-colors border border-slate-200 shadow-sm">
                                ยกเลิกคำขอเข้าร่วม
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="otpModal" class="hidden fixed inset-0 bg-slate-900/80 z-[100] flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-white p-10 rounded-[3rem] shadow-2xl max-w-sm w-full mx-4 text-center border-t-[12px] border-purple-500 relative">
            <h3 class="text-2xl font-black text-slate-800 mb-2">รหัส OTP ของคุณ</h3>
            <p class="text-slate-500 font-medium">รหัสจะมีอายุการใช้งาน 30 นาที</p>
            <div id="otpDisplay" class="text-5xl font-black tracking-[0.2em] text-purple-600 bg-purple-50 py-8 rounded-[2rem] my-8 border-2 border-dashed border-purple-200">------</div>
            
            <div class="flex gap-3">
                <button type="button" onclick="generateOTP(true)" class="flex-1 py-4 bg-slate-100 text-slate-700 font-bold rounded-2xl hover:bg-slate-200 transition shadow-sm text-sm">🔄 ขอรหัสใหม่</button>
                <button type="button" onclick="closeOTP()" class="flex-1 py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-black transition shadow-xl">รับทราบ</button>
            </div>
        </div>
    </div>  

    <div id="statusModal" class="hidden fixed inset-0 bg-slate-900/60 z-[999] flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl max-w-sm w-full text-center transform transition-all border-t-8 border-green-500">
            <div id="modalIconBg" class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-green-100">
                <span id="modalIconText" class="text-5xl">🥳</span>
            </div>
            <h3 id="modalTitle" class="text-2xl font-black text-slate-800 mb-2">สำเร็จ!</h3>
            <p id="modalMessage" class="text-slate-500 mb-8 font-medium"></p>
            <button type="button" onclick="closeStatusModal()" class="w-full py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-black transition shadow-lg">ตกลง</button>
        </div>
    </div>

    <div id="leaveConfirmModal" class="hidden fixed inset-0 bg-slate-900/60 z-[120] flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-2xl max-w-sm w-full text-center border-t-8 border-red-500 transform transition-all">
            <div class="w-16 h-16 md:w-20 md:h-20 bg-red-50 text-red-500 text-3xl md:text-4xl rounded-full flex items-center justify-center mx-auto mb-4 border border-red-100">🚪</div>
            <h3 class="text-xl md:text-2xl font-black mb-2 text-slate-800">ยืนยันการดำเนินการ?</h3>
            <p class="text-slate-500 mb-6 md:mb-8 text-sm font-medium">คุณต้องการออกจากกิจกรรมนี้ใช่หรือไม่?</p>
            <div class="flex gap-2 md:gap-3">
                <button onclick="closeLeaveModal()" class="flex-1 py-3 md:py-3.5 bg-slate-100 text-slate-600 font-bold rounded-xl md:rounded-2xl hover:bg-slate-200 transition">ยกเลิก</button>
                <button id="confirmLeaveBtn" class="flex-1 py-3 md:py-3.5 bg-red-500 text-white font-bold rounded-xl md:rounded-2xl hover:bg-red-600 transition shadow-lg shadow-red-200">ยืนยัน</button>
            </div>
        </div>
    </div>

    <script>
        const eventId = "<?php echo $activity['EventID']; ?>";
        const dbStatus = "<?php echo $status; ?>";

        function scrollCarouselDetail(carouselId, direction) {
            const carousel = document.getElementById(carouselId);
            if (carousel) {
                const scrollAmount = carousel.clientWidth;
                carousel.scrollBy({ left: scrollAmount * direction, behavior: 'smooth' });
            }
        }

        window.onload = function() {
            if (dbStatus === 'checked_in') showSuccessLayout();
            localStorage.removeItem('checked_in_event_' + eventId);
        };

        function showSuccessLayout() {
            const badge = document.getElementById('badge_status');
            if (badge) {
                badge.innerText = "✨ เข้าร่วมสำเร็จ";
                badge.className = "absolute -top-6 right-8 px-6 py-2.5 rounded-full font-black text-sm shadow-xl backdrop-blur-md border bg-blue-500 text-white border-blue-400";
            }
            const waitingDiv = document.getElementById('waiting_otp');
            const successDiv = document.getElementById('success_checked_in');
            if (waitingDiv) waitingDiv.classList.add('hidden');
            if (successDiv) successDiv.classList.remove('hidden');
        }

        function generateOTP(forceNew = false) {
            const formData = new URLSearchParams();
            formData.append('event_id', eventId);
            if (forceNew) formData.append('force_new', '1');
            
            const display = document.getElementById('otpDisplay');
            display.innerText = "กำลังขอ...";
            document.getElementById('otpModal').style.display = 'flex';

            fetch('generate_otp', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') display.innerText = data.otp;
                else { display.innerText = "Error"; alert(data.message || 'เกิดข้อผิดพลาด'); }
            })
            .catch(() => { display.innerText = "Error"; alert('ไม่สามารถเชื่อมต่อได้'); });
        }

        function verifyOTP() {
            const inputOtp = document.getElementById('input_verify_otp').value;
            if (inputOtp.trim() === '') {
                showStatusModal('กรุณากรอกรหัส', 'โปรดใส่รหัส OTP ก่อนกดยืนยัน', '⚠️', 'error');
                return;
            }
            const formData = new URLSearchParams();
            formData.append('event_id', eventId);
            formData.append('otp', inputOtp);

            fetch('updete_checkin', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            })
            .then(res => res.text())
            .then(result => {
                const resText = result.trim();
                if (resText === 'Success') {
                    showSuccessLayout();
                    showStatusModal('ยืนยันสำเร็จ!', 'เข้าร่วมกิจกรรมเรียบร้อยแล้ว!', '🥳', 'success');
                } else if (resText === 'Invalid_OTP') {
                    showStatusModal('รหัสไม่ถูกต้อง', 'รหัส OTP อาจหมดอายุ หรือกรอกผิด', '❌', 'error');
                } else showStatusModal('ผิดพลาด', 'อัปเดตระบบไม่สำเร็จ', '❌', 'error');
            })
            .catch(() => showStatusModal('ผิดพลาด', 'เชื่อมต่อระบบไม่ได้', '❌', 'error'));
        }

        function confirmLeaveActivity() {
            document.getElementById('leaveConfirmModal').classList.remove('hidden');
        }

        function closeLeaveModal() {
            document.getElementById('leaveConfirmModal').classList.add('hidden');
        }

        document.getElementById('confirmLeaveBtn').onclick = function() {
            window.location.href = 'leave_activity?id=' + eventId + '&from=dashboard';
        };

        function showStatusModal(title, message, icon = '🥳', type = 'success') {
            const modal = document.getElementById('statusModal');
            const box = modal.querySelector('div');
            const bg = document.getElementById('modalIconBg');

            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalMessage').innerText = message;
            document.getElementById('modalIconText').innerText = icon;

            if (type === 'error') {
                box.classList.replace('border-green-500', 'border-red-500');
                bg.classList.replace('bg-green-50', 'bg-red-50');
                bg.classList.replace('border-green-100', 'border-red-100');
            } else {
                box.classList.replace('border-red-500', 'border-green-500');
                bg.classList.replace('bg-red-50', 'bg-green-50');
                bg.classList.replace('border-red-100', 'border-green-100');
            }
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').style.display = 'none';
            document.getElementById('statusModal').classList.add('hidden');
            if (document.getElementById('modalTitle').innerText.includes('สำเร็จ')) {
                window.location.href = 'dashboard';
            }
        }

        function closeOTP() { document.getElementById('otpModal').style.display = 'none'; }
        window.onclick = function(e) { if (e.target == document.getElementById('otpModal')) closeOTP(); }
    </script>
</body>

</html>