<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Activities - ActiSpace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background-color: #f8fafc;
            background-image: radial-gradient(circle at 15% 50%, rgba(139, 92, 246, 0.12), transparent 40%), radial-gradient(circle at 85% 30%, rgba(99, 102, 241, 0.12), transparent 40%), linear-gradient(to right, rgba(200, 200, 200, 0.25) 1px, transparent 1px), linear-gradient(to bottom, rgba(200, 200, 200, 0.25) 1px, transparent 1px);
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

<body class="min-h-screen pb-10 relative">

    <nav class="flex justify-between items-center px-4 sm:px-6 md:px-12 py-4 bg-white/90 backdrop-blur-xl sticky top-0 z-50 border-b border-white shadow-sm mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <button onclick="toggleMobileMenu()" class="lg:hidden flex items-center justify-center w-10 h-10 bg-slate-50 text-slate-600 rounded-full border border-slate-200 hover:bg-slate-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div class="text-2xl md:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500 flex items-center gap-1 md:gap-2">
                <a href="dashboard" class="flex items-center"><span class="text-3xl md:text-4xl text-purple-600">🚀</span><span class="hidden sm:inline ml-1">ActiSpace</span></a>
            </div>
        </div>

        <div class="hidden lg:flex gap-2 p-1.5 bg-slate-100/80 backdrop-blur-md border border-slate-200/50 rounded-full shadow-inner">
            <a href="dashboard" class="text-slate-600 hover:text-purple-600 hover:bg-white px-8 py-2.5 rounded-full text-base font-bold transition">แดชบอร์ด</a>
            <a href="all_activities" class="bg-white text-purple-600 px-8 py-2.5 rounded-full text-base font-bold shadow-sm transition transform hover:scale-105">กิจกรรมทั้งหมด</a>
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
                <a href="profile" class="block px-5 py-3.5 text-sm font-bold text-slate-600 hover:bg-purple-50 hover:text-purple-600 transition flex items-center gap-3"><span class="text-lg">📝</span> ดูรายละเอียด</a>
                <div class="border-t border-slate-100"></div>
                <a href="logout" class="block px-5 py-3.5 text-sm font-bold text-red-500 hover:bg-red-50 transition flex items-center gap-3"><span class="text-lg">🚪</span> ออกจากระบบ</a>
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
                <a href="dashboard" class="px-5 py-4 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition flex items-center gap-3"><span class="text-xl">🏠</span> แดชบอร์ด</a>
                <a href="all_activities" class="px-5 py-4 rounded-2xl font-bold text-purple-600 bg-purple-50 transition flex items-center gap-3"><span class="text-xl">🔍</span> กิจกรรมทั้งหมด</a>
                <a href="search_users" class="px-5 py-4 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition flex items-center gap-3"><span class="text-xl">🔍</span> ค้นหาผู้ใช้</a>
                <?php if ($_SESSION["role"] == 'creator'): ?>
                    <a href="my_activities" class="px-5 py-4 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition flex items-center gap-3"><span class="text-xl">📋</span> จัดการกิจกรรม</a>
                    <a href="create_activity" class="px-5 py-4 mt-2 bg-purple-600 text-white rounded-2xl font-bold hover:bg-purple-700 transition flex items-center justify-center shadow-md">➕ สร้างกิจกรรม</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white/90 backdrop-blur-md p-5 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-sm border border-white mb-8 md:mb-10">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 md:gap-5">
                <div class="text-center lg:text-left w-full lg:w-1/3">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-800 tracking-tight mb-1 md:mb-2">สำรวจกิจกรรม 🚀</h2>
                    <p class="text-slate-500 font-medium text-sm md:text-base">ค้นหาประสบการณ์ใหม่ๆ ที่เหมาะกับคุณ</p>
                </div>

                <form method="GET" action="all_activities" class="w-full lg:w-2/3 flex flex-col gap-2">
                    <input type="hidden" name="action" value="all_activities">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                        <input type="text" name="search" placeholder="🔍 ชื่อกิจกรรม..." value="<?php echo htmlspecialchars($search); ?>" class="px-4 py-3 bg-slate-50 text-slate-800 focus:outline-none font-medium border border-slate-200 rounded-xl w-full">
                        <input type="text" name="creator" placeholder="👤 ชื่อผู้จัด..." value="<?php echo isset($creator) ? htmlspecialchars($creator) : ''; ?>" class="px-4 py-3 bg-slate-50 text-slate-800 focus:outline-none font-medium border border-slate-200 rounded-xl w-full">
                        <input type="date" name="date_from" value="<?php echo isset($date_from) ? htmlspecialchars($date_from) : ''; ?>" class="px-4 py-3 bg-slate-50 text-slate-500 focus:outline-none font-medium border border-slate-200 rounded-xl w-full">
                        <input type="date" name="date_to" value="<?php echo isset($date_to) ? htmlspecialchars($date_to) : ''; ?>" class="px-4 py-3 bg-slate-50 text-slate-500 focus:outline-none font-medium border border-slate-200 rounded-xl w-full">
                        <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-xl font-bold hover:bg-purple-600 transition shadow-md">ค้นหา</button>
                    </div>
                    <?php if ($search != "" || (isset($creator) && $creator != "") || (isset($date_from) && $date_from != "") || (isset($date_to) && $date_to != "")): ?>
                        <div class="flex justify-end mt-2">
                            <a href="all_activities" class="inline-flex items-center justify-center px-6 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-full hover:bg-slate-100 transition">ล้างการค้นหา ✕</a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            <?php if (isset($activities) && $activities && $activities->num_rows > 0): ?>
                <?php foreach ($activities as $activity): ?>
                    <div class="bg-white/90 backdrop-blur-md rounded-[1.5rem] md:rounded-[2rem] shadow-sm flex flex-col hover:shadow-xl hover:-translate-y-1 border border-white transition-all duration-300 overflow-hidden group">

                        <?php
                        $event_id = $activity['EventID'];
                        $images = $model->getEventImages($event_id);
                        ?>
                        <div onclick="window.location.href='view_activity?id=<?php echo $activity['EventID']; ?>'"
                            class="relative w-full aspect-[4/3] bg-slate-100 overflow-hidden shrink-0">
                            <?php if (count($images) > 0): ?>
                                <div id="carousel-all-<?php echo $event_id; ?>" class="flex w-full h-full overflow-x-hidden snap-x snap-mandatory scroll-smooth hide-scrollbar">
                                    <?php foreach ($images as $img_path): ?>
                                        <div class="w-full h-full flex-shrink-0 snap-center relative">
                                            <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>
                                            <img src="<?php echo $base_url . '/' . ltrim(htmlspecialchars($img_path), '/'); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($images) > 1): ?>
                                    <button onclick="scrollCarousel('carousel-all-<?php echo $event_id; ?>', -1)" type="button" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-10 shadow-md">&#10094;</button>
                                    <button onclick="scrollCarousel('carousel-all-<?php echo $event_id; ?>', 1)" type="button" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-10 shadow-md">&#10095;</button>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-50 font-bold">ไม่มีรูปภาพ</div>
                            <?php endif; ?>

                            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm text-slate-800 px-3 py-1.5 rounded-xl text-xs font-bold shadow-sm flex items-center gap-1">
                                👥 <?php echo $activity['CurrentPeople'] ?? 0; ?>/<?php echo $activity['MaxPeople'] ?? 0; ?>
                            </div>
                        </div>

                        <div class="p-5 md:p-6 flex flex-col flex-1">
                            <h4 class="text-lg md:text-xl font-black mb-2 text-slate-800 break-all leading-tight line-clamp-2"><?php echo htmlspecialchars($activity['Title']); ?></h4>
                            <p class="text-sm text-slate-500 mb-4 font-medium">👤 ผู้จัด: <span class="text-purple-600 font-bold"><?php echo htmlspecialchars($activity['Name']); ?></span></p>

                            <div class="bg-slate-50 p-3 rounded-2xl mb-4 border border-slate-100">
                                <p class="text-xs font-bold text-slate-700 flex items-center gap-2 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-purple-500"></span> เริ่ม: <?php echo date('d M Y - H:i', strtotime($activity['StartDate'])); ?>
                                </p>
                                <p class="text-xs font-bold text-slate-700 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-red-400"></span> สิ้นสุด: <?php echo date('d M Y - H:i', strtotime($activity['EndDate'])); ?>
                                </p>
                            </div>

                            <p class="text-slate-500 text-sm mb-6 flex-1 line-clamp-2 leading-relaxed"><?php echo htmlspecialchars($activity['Desciption']); ?></p>

                            <?php
                            date_default_timezone_set('Asia/Bangkok');
                            $is_ended = (strtotime($activity['EndDate']) < time());
                            $joinedEventIDs = $model->getJoinedEventIDs($_SESSION['user_id']);
                            $is_joined = in_array($activity['EventID'], $joinedEventIDs);
                            $is_creator = ($activity['creator_id'] == $_SESSION['user_id']);
                            ?>

                            <div class="flex gap-2 mt-auto">
                                <a href="view_activity?id=<?php echo $activity['EventID']; ?>" class="flex-1 text-center bg-slate-50 text-slate-600 font-bold py-3.5 rounded-xl hover:bg-slate-100 transition text-sm flex items-center justify-center border border-slate-200">🔍 ดูข้อมูล</a>

                                <?php if ($is_creator): ?>
                                    <button disabled class="flex-1 bg-slate-100 text-slate-400 font-bold py-3.5 rounded-xl cursor-not-allowed text-sm">👑 ของคุณ</button>
                                <?php elseif ($is_ended): ?>
                                    <button disabled class="flex-1 bg-slate-100 text-slate-400 font-bold py-3.5 rounded-xl cursor-not-allowed text-sm">⛔ จบแล้ว</button>
                                <?php elseif ($is_joined): ?>
                                    <button disabled class="flex-1 bg-green-50 text-green-600 border border-green-200 font-bold py-3.5 rounded-xl cursor-not-allowed text-sm">✅ เข้าร่วมแล้ว</button>
                                <?php elseif ($activity['CurrentPeople'] >= $activity['MaxPeople']): ?>
                                    <button disabled class="flex-1 bg-slate-100 text-slate-400 font-bold py-3.5 rounded-xl cursor-not-allowed text-sm">🔒 เต็มแล้ว</button>
                                <?php else: ?>
                                    <a href="join_activity?id=<?php echo $activity['EventID']; ?>" class="flex-1 text-center bg-purple-600 text-white font-bold py-3.5 rounded-xl hover:bg-purple-700 transition shadow-md text-sm flex items-center justify-center active:scale-95">✍️ เข้าร่วม</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full bg-white/80 border border-dashed border-slate-300 rounded-[2.5rem] text-center py-20 shadow-sm backdrop-blur-sm">
                    <span class="text-5xl block mb-4">📭</span>
                    <h3 class="text-2xl font-black text-slate-800 mb-2">ไม่มีกิจกรรมในขณะนี้</h3>
                    <p class="text-slate-500 font-medium">ลองเปลี่ยนคำค้นหา หรือล้างตัวกรองดูสิ</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="statusModal" class="hidden fixed inset-0 bg-slate-900/60 z-[999] flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl max-w-sm w-full text-center transform transition-all scale-100 border-t-8 border-green-500">
            <div id="modalIconBg" class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner border border-green-100">
                <span id="modalIconText" class="text-5xl">🥳</span>
            </div>
            <h3 id="modalTitle" class="text-2xl font-black text-slate-800 mb-2">สำเร็จ!</h3>
            <p id="modalMessage" class="text-slate-500 mb-8 font-medium">ข้อความแจ้งเตือนของคุณ</p>
            <button onclick="closeStatusModal()" class="w-full py-4 bg-slate-900 text-white font-bold text-lg rounded-2xl hover:bg-purple-600 transition shadow-lg active:scale-95">ตกลง</button>
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

        let isJoinSuccessRedirect = false;

        function showStatusModal(title, message, icon = '🥳', type = 'success') {
            const modal = document.getElementById('statusModal');
            const container = modal.querySelector('div');
            const iconBg = document.getElementById('modalIconBg');

            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalMessage').innerText = message;
            document.getElementById('modalIconText').innerText = icon;

            if (type === 'error') {
                container.classList.replace('border-green-500', 'border-red-500');
                iconBg.classList.replace('bg-green-50', 'bg-red-50');
                iconBg.classList.replace('border-green-100', 'border-red-100');
            } else {
                container.classList.replace('border-red-500', 'border-green-500');
                iconBg.classList.replace('bg-red-50', 'bg-green-50');
                iconBg.classList.replace('border-red-100', 'border-green-100');
            }
            modal.classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
            if (isJoinSuccessRedirect) {
                window.location.href = 'all_activities';
            } else {
                const url = new URL(window.location);
                url.searchParams.delete('status');
                url.searchParams.delete('msg');
                url.searchParams.delete('join_success');
                url.searchParams.delete('join_error');
                window.history.replaceState(null, null, url);
            }
        }

        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const msgType = urlParams.get('msg');
            const joinSuccess = urlParams.get('join_success');
            const joinError = urlParams.get('join_error');

            if (status === 'success') {
                if (msgType === 'request_sent') {
                    isJoinSuccessRedirect = true;
                    showStatusModal('ส่งคำขอสำเร็จ!', 'กรุณารอผู้จัดกิจกรรมอนุมัติการเข้าร่วม', '📩', 'success');
                } else if (msgType === 'leave_done') {
                    showStatusModal('ยกเลิกสำเร็จ', 'คุณได้ออกจากกิจกรรมนี้เรียบร้อยแล้ว', '👋', 'success');
                }
            } else if (status === 'error' && msgType === 'leave_fail') {
                showStatusModal('เกิดข้อผิดพลาด', 'ไม่สามารถยกเลิกกิจกรรมได้', '❌', 'error');
            }

            if (joinSuccess === '1') {
                isJoinSuccessRedirect = true;
                showStatusModal('ส่งคำขอสำเร็จ!', 'คุณสามารถเช็คสถานะกิจกรรมได้ที่หน้า \n "แดชบอร์ด"', '✅', 'success');
            } else if (joinError) {
                let errMsg = "เกิดข้อผิดพลาดในการเข้าร่วมกิจกรรม";
                if (joinError === 'ended') errMsg = "กิจกรรมนี้สิ้นสุดลงแล้ว ไม่สามารถเข้าร่วมได้";
                else if (joinError === 'full') errMsg = "ขออภัย! กิจกรรมนี้ที่นั่งเต็มแล้ว";
                else if (joinError === 'exists') errMsg = "คุณได้ส่งคำขอเข้าร่วมกิจกรรมนี้ไปแล้ว!";
                showStatusModal('ไม่สามารถเข้าร่วมได้', errMsg, '⚠️', 'error');
            }
        }

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
    </script>
</body>

</html>