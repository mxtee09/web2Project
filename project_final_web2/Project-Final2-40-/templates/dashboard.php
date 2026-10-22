<?php date_default_timezone_set('Asia/Bangkok'); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ActiSpace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background-color: #f3f4f6;
            background-image: radial-gradient(circle at 15% 50%, rgba(139, 92, 246, 0.2), transparent 30%), radial-gradient(circle at 85% 30%, rgba(99, 102, 241, 0.2), transparent 30%), linear-gradient(to right, rgba(200, 200, 200, 0.3) 1px, transparent 1px), linear-gradient(to bottom, rgba(200, 200, 200, 0.3) 1px, transparent 1px);
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

<body class="min-h-screen pb-10">

    <nav class="flex justify-between items-center px-4 sm:px-6 md:px-12 py-4 bg-white/90 backdrop-blur-xl sticky top-0 z-50 border-b border-white shadow-sm mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <button onclick="toggleMobileMenu()" class="lg:hidden flex items-center justify-center w-10 h-10 bg-slate-50 text-slate-600 rounded-full border border-slate-200 hover:bg-slate-100 transition active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div class="text-2xl md:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500 flex items-center gap-1 md:gap-2">
                <a href="dashboard" class="flex items-center"><span class="text-3xl md:text-4xl text-purple-600">🚀</span><span class="hidden sm:inline ml-1">ActiSpace</span></a>
            </div>
        </div>

        <div class="hidden lg:flex gap-2 p-1.5 bg-slate-100/80 backdrop-blur-md border border-slate-200/50 rounded-full shadow-inner">
            <a href="dashboard" class="bg-white text-purple-600 px-8 py-2.5 rounded-full text-base font-bold shadow-sm transition transform hover:scale-105">แดชบอร์ด</a>
            <a href="all_activities" class="text-slate-600 hover:text-purple-600 hover:bg-white px-8 py-2.5 rounded-full text-base font-bold transition">กิจกรรมทั้งหมด</a>
            <?php if ($_SESSION["role"] == 'creator'): ?>
                <a href="my_activities" class="text-slate-600 hover:text-purple-600 hover:bg-white px-8 py-2.5 rounded-full text-base font-bold transition">จัดการกิจกรรม</a>
                <a href="search_users" class="text-slate-600 hover:text-purple-600 hover:bg-white px-8 py-2.5 rounded-full text-base font-bold transition">ค้นหาผู้ใช้</a>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-2 md:gap-4 relative">
            <button onclick="toggleProfileMenu()" class="flex items-center gap-2 text-xs md:text-sm font-bold text-slate-600 bg-white px-3 py-2 md:px-5 md:py-2.5 rounded-full shadow-sm border border-slate-200 hover:bg-slate-50 transition active:scale-95">
                👤 <span class="hidden sm:inline"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                <span class="text-[10px] text-slate-400">▼</span>
            </button>
            <div id="profileDropdown" class="hidden absolute right-0 top-full mt-3 w-56 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-white overflow-hidden z-[100] transform transition-all">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">บัญชีของคุณ</p>
                    <p class="text-sm font-black text-slate-800 truncate"><?php echo htmlspecialchars($_SESSION["username"]); ?></p>
                </div>
                <a href="profile" class="block px-5 py-3.5 text-sm font-bold text-slate-600 hover:bg-purple-50 hover:text-purple-600 transition flex items-center gap-3">
                    <span class="text-lg">📝</span> ดูรายละเอียด
                </a>
                <div class="border-t border-slate-100"></div>
                <a href="logout" class="block px-5 py-3.5 text-sm font-bold text-red-500 hover:bg-red-50 transition flex items-center gap-3">
                    <span class="text-lg">🚪</span> ออกจากระบบ
                </a>
            </div>
        </div>
    </nav>

    <div id="mobileMenu" class="hidden fixed inset-0 bg-slate-900/60 z-[100] backdrop-blur-sm lg:hidden transition-opacity">
        <div class="fixed inset-y-0 left-0 w-3/4 max-w-sm bg-white shadow-2xl p-6 flex flex-col overflow-y-auto">
            <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-100">
                <span class="text-2xl font-black text-purple-600">🚀 ActiSpace</span>
                <button onclick="toggleMobileMenu()" class="text-slate-400 hover:text-red-500 text-2xl font-bold bg-slate-50 w-10 h-10 rounded-full flex items-center justify-center transition">✕</button>
            </div>
            <div class="flex flex-col gap-3 flex-1">
                <a href="dashboard" class="px-5 py-4 rounded-2xl font-bold text-purple-600 bg-purple-50 transition flex items-center gap-3"><span class="text-xl">🏠</span> แดชบอร์ด</a>
                <a href="all_activities" class="px-5 py-4 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition flex items-center gap-3"><span class="text-xl">🔍</span> กิจกรรมทั้งหมด</a>
                <a href="search_users" class="px-5 py-4 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition flex items-center gap-3"><span class="text-xl">🔍</span> ค้นหาผู้ใช้</a>
                <?php if ($_SESSION["role"] == 'creator'): ?>
                    <a href="my_activities" class="px-5 py-4 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition flex items-center gap-3"><span class="text-xl">📋</span> จัดการกิจกรรม</a>
                    <a href="create_activity" class="px-5 py-4 mt-2 bg-purple-600 text-white rounded-2xl font-bold hover:bg-purple-700 transition flex items-center justify-center shadow-md">➕ สร้างกิจกรรม</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6 md:p-12 rounded-[2rem] md:rounded-[3rem] shadow-xl shadow-purple-200 mb-8 md:mb-12 relative overflow-hidden border-4 border-white/20">
            <div class="relative z-10 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-2 tracking-tight leading-tight">สวัสดีคุณ <span class="text-purple-200"><?php echo htmlspecialchars($_SESSION["username"]); ?> 👋</span></h2>
                    <p class="text-purple-100 font-medium text-base md:text-lg">ยินดีต้อนรับกลับสู่พื้นที่กิจกรรมของคุณ</p>
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <a href="all_activities" class="w-full text-center bg-white text-purple-600 font-bold px-6 md:px-8 py-3 md:py-4 rounded-full hover:bg-purple-50 transition-all shadow-xl active:scale-95 md:text-lg">🔍 ค้นหากิจกรรม</a>
                </div>
            </div>
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute left-10 -bottom-10 w-32 h-32 bg-purple-400/30 rounded-full blur-xl hidden md:block"></div>
        </div>

        <?php
        $hasJoined = (isset($joinedActivities) && $joinedActivities && $joinedActivities->num_rows > 0);
        $activitiesArray = [];
        if ($hasJoined) {
            while ($item = $joinedActivities->fetch_assoc()) {
                $activitiesArray[] = $item;
            }
            $activitiesArray = array_reverse($activitiesArray);
        }
        ?>

        <?php if (!$hasJoined): ?>
            <div class="bg-white/80 backdrop-blur-md p-8 md:p-16 rounded-[2rem] md:rounded-[3rem] shadow-sm border border-white text-center animate-in fade-in duration-500">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-purple-50 text-4xl md:text-5xl flex items-center justify-center rounded-full mx-auto mb-6 shadow-inner border border-purple-100">🎯</div>
                <h3 class="text-2xl md:text-3xl font-black text-slate-800 mb-3">ยังไม่มีกิจกรรมที่เข้าร่วม</h3>
                <p class="text-slate-500 mb-8 font-medium text-base md:text-lg">เริ่มต้นการเดินทางใหม่ๆ ค้นหากิจกรรมที่น่าสนใจได้เลย</p>
                <a href="all_activities" class="inline-block bg-slate-900 text-white font-bold px-8 md:px-10 py-4 md:py-5 rounded-full hover:bg-purple-600 transition shadow-xl text-base md:text-lg">🚀 สำรวจกิจกรรมทั้งหมด</a>
            </div>
        <?php else: ?>
            <div class="flex items-center gap-3 mb-6 px-2">
                <span class="w-2 h-8 bg-purple-500 rounded-full block"></span>
                <h3 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight">กิจกรรมที่คุณเข้าร่วม</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <?php foreach ($activitiesArray as $row): ?>
                    <div onclick="window.location.href='activity_detail?id=<?php echo $row['EventID']; ?>'" class="cursor-pointer group bg-white/90 backdrop-blur-md p-5 rounded-[2rem] shadow-sm border border-white hover:shadow-xl hover:border-purple-200 hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">

                        <?php
                        $event_id = $row['EventID'];
                        $images = $model->getEventImages($event_id);
                        ?>
                        <div onclick="window.location.href='view_activity?id=<?php echo $activity['EventID']; ?>'"
                            class="relative w-full aspect-[4/3] mb-5 rounded-2xl overflow-hidden bg-slate-100 shrink-0 shadow-inner">
                            <?php if (count($images) > 0): ?>
                                <div id="carousel-dash-<?php echo $event_id; ?>" class="flex w-full h-full overflow-x-hidden snap-x snap-mandatory scroll-smooth hide-scrollbar">
                                    <?php foreach ($images as $img_path): ?>
                                        <div class="w-full h-full flex-shrink-0 snap-center relative">
                                            <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>
                                            <img src="<?php echo $base_url . '/' . ltrim(htmlspecialchars($img_path), '/'); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($images) > 1): ?>
                                    <button onclick="event.stopPropagation(); scrollCarousel('carousel-dash-<?php echo $event_id; ?>', -1)" type="button" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-10 shadow-md">&#10094;</button>
                                    <button onclick="event.stopPropagation(); scrollCarousel('carousel-dash-<?php echo $event_id; ?>', 1)" type="button" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-10 shadow-md">&#10095;</button>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-300 font-bold">ไม่มีรูปภาพ</div>
                            <?php endif; ?>

                            <div class="absolute top-3 right-3">
                                <?php
                                $status = strtolower($row['Status']);
                                $is_ended = (time() > strtotime($row['EndDate']));
                                if ($status == 'checked_in') echo '<span class="bg-blue-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg backdrop-blur-md">✨ เข้าร่วมแล้ว</span>';
                                elseif ($is_ended) echo '<span class="bg-slate-800 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg backdrop-blur-md">⌛ จบแล้ว</span>';
                                elseif ($status == 'approved') echo '<span class="bg-green-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg backdrop-blur-md">✅ รอ OTP</span>';
                                elseif ($status == 'rejected') echo '<span class="bg-red-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg backdrop-blur-md">❌ ปฏิเสธ</span>';
                                else echo '<span class="bg-yellow-400 text-yellow-900 px-3 py-1.5 rounded-full text-xs font-bold shadow-lg backdrop-blur-md">⏳ รออนุมัติ</span>';
                                ?>
                            </div>
                        </div>

                        <h3 class="text-lg md:text-xl font-black mb-3 text-slate-800 break-all leading-tight group-hover:text-purple-600 transition-colors"><?php echo htmlspecialchars($row['Title']); ?></h3>

                        <div class="space-y-2 mb-5 flex-1">
                            <p class="text-sm text-slate-500 font-medium line-clamp-1">👤 ผู้จัด: <span class="font-bold text-slate-800"><?php echo htmlspecialchars($row['creator_name'] ?? 'ไม่ระบุ'); ?></span></p>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100/50">
                                <p class="text-xs font-bold text-slate-700 flex items-center gap-2 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-purple-500"></span> เริ่ม: <?php echo date('d M Y H:i', strtotime($row['StartDate'])); ?>
                                </p>
                                <p class="text-xs font-bold text-slate-700 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-red-400"></span> สิ้นสุด: <?php echo date('d M Y H:i', strtotime($row['EndDate'])); ?>
                                </p>
                            </div>
                        </div>

                        <?php if (!$is_ended && $status != 'rejected'): ?>
                            <button onclick="event.stopPropagation(); confirmLeaveActivity(<?php echo $row['EventID']; ?>)" class="w-full bg-white text-red-500 font-bold py-3 rounded-xl hover:bg-red-50 hover:border-red-200 transition-colors text-sm border border-slate-200 shadow-sm mt-auto">
                                ออกจากกิจกรรม
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div id="leaveConfirmModal" class="hidden fixed inset-0 bg-slate-900/60 z-[120] flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-2xl max-w-sm w-full text-center border-t-8 border-red-500 transform transition-all">
            <div class="w-16 h-16 md:w-20 md:h-20 bg-red-50 text-red-500 text-3xl md:text-4xl rounded-full flex items-center justify-center mx-auto mb-4 border border-red-100">🚪</div>
            <h3 class="text-xl md:text-2xl font-black mb-2 text-slate-800">ยืนยันการยกเลิก?</h3>
            <p class="text-slate-500 mb-6 md:mb-8 text-sm font-medium">หากต้องการกลับมาใหม่ คุณจะต้องกดเข้าร่วมและรอให้ผู้จัดอนุมัติอีกครั้ง</p>
            <div class="flex gap-2 md:gap-3">
                <button onclick="closeLeaveModal()" class="flex-1 py-3 md:py-3.5 bg-slate-100 text-slate-600 font-bold rounded-xl md:rounded-2xl hover:bg-slate-200 transition">ปิด</button>
                <button id="confirmLeaveBtn" class="flex-1 py-3 md:py-3.5 bg-red-500 text-white font-bold rounded-xl md:rounded-2xl hover:bg-red-600 transition shadow-lg shadow-red-200">ยืนยันการออก</button>
            </div>
        </div>
    </div>

    <div id="statusModal" class="hidden fixed inset-0 bg-slate-900/60 z-[999] flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-2xl max-w-sm w-full text-center transform transition-all border-t-8 border-green-500">
            <div id="modalIconBg" class="w-20 h-20 md:w-24 md:h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                <span id="modalIconText" class="text-4xl md:text-5xl">🥳</span>
            </div>
            <h3 id="modalTitle" class="text-xl md:text-2xl font-black text-slate-800 mb-2">สำเร็จ!</h3>
            <p id="modalMessage" class="text-slate-500 mb-8 font-medium">ข้อความแจ้งเตือน</p>
            <button onclick="closeStatusModal()" class="w-full py-3.5 md:py-4 bg-slate-900 text-white font-bold text-lg rounded-xl md:rounded-2xl hover:bg-slate-800 transition shadow-lg active:scale-95">ตกลง</button>
        </div>
    </div>

    <script>
        function scrollCarousel(carouselId, direction) {
            const carousel = document.getElementById(carouselId);
            if (carousel) {
                const scrollAmount = carousel.clientWidth;
                carousel.scrollBy({
                    left: scrollAmount * direction,
                    behavior: 'smooth'
                });
            }
        }
        let leaveEventId = null;

        function confirmLeaveActivity(id) {
            leaveEventId = id;
            document.getElementById('leaveConfirmModal').classList.remove('hidden');
        }

        function closeLeaveModal() {
            document.getElementById('leaveConfirmModal').classList.add('hidden');
            leaveEventId = null;
        }

        document.getElementById('confirmLeaveBtn').onclick = function() {
            if (leaveEventId) {
                localStorage.removeItem('checked_in_event_' + leaveEventId);
                window.location.href = 'leave_activity?id=' + leaveEventId + '&from=dashboard';
            }
        };

        function toggleProfileMenu() {
            document.getElementById('profileDropdown').classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
        window.addEventListener('click', function(e) {
            if (!e.target.closest('button[onclick="toggleProfileMenu()"]') && !e.target.closest('#profileDropdown')) {
                const menu = document.getElementById('profileDropdown');
                if (menu && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            }
            if (e.target.id === 'mobileMenu') {
                toggleMobileMenu();
            }
        });

        function showStatusModal(title, message, icon = '🥳', type = 'success') {
            const modal = document.getElementById('statusModal');
            const container = modal.querySelector('div.bg-white');
            const iconBg = document.getElementById('modalIconBg');

            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalMessage').innerText = message;
            document.getElementById('modalIconText').innerText = icon;

            if (type === 'error') {
                container.classList.replace('border-green-500', 'border-red-500');
                iconBg.classList.replace('bg-green-100', 'bg-red-100');
            } else {
                container.classList.replace('border-red-500', 'border-green-500');
                iconBg.classList.replace('bg-red-100', 'bg-green-100');
            }
            modal.classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
            const url = new URL(window.location);
            url.searchParams.delete('status');
            url.searchParams.delete('msg');
            window.history.replaceState(null, null, url);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const msgType = urlParams.get('msg');
            if (status === 'success' && msgType === 'leave_done') {
                showStatusModal('ยกเลิกสำเร็จ', 'คุณได้ออกจากกิจกรรมนี้เรียบร้อยแล้ว', '👋', 'success');
            } else if (status === 'error' && msgType === 'leave_fail') {
                showStatusModal('เกิดข้อผิดพลาด', 'ไม่สามารถยกเลิกกิจกรรมได้', '❌', 'error');
            }
        });
    </script>
</body>

</html>