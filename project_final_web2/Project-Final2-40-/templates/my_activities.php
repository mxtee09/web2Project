<?php date_default_timezone_set('Asia/Bangkok'); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการกิจกรรมของฉัน - ActiSpace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background-color: #f3f4f6;
            background-image: radial-gradient(circle at 15% 50%, rgba(139, 92, 246, 0.12), transparent 40%), radial-gradient(circle at 85% 30%, rgba(99, 102, 241, 0.12), transparent 40%), linear-gradient(to right, rgba(200, 200, 200, 0.25) 1px, transparent 1px), linear-gradient(to bottom, rgba(200, 200, 200, 0.25) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 40px 40px, 40px 40px;
            background-attachment: fixed;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
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
            <a href="all_activities" class="text-slate-600 hover:text-purple-600 hover:bg-white px-8 py-2.5 rounded-full text-base font-bold transition">กิจกรรมทั้งหมด</a>
            <a href="my_activities" class="bg-white text-purple-600 px-8 py-2.5 rounded-full text-base font-bold shadow-sm transition transform hover:scale-105">จัดการกิจกรรม</a>
            <a href="search_users" class="text-slate-600 hover:text-purple-600 hover:bg-white px-8 py-2.5 rounded-full text-base font-bold transition">ค้นหาผู้ใช้</a>
        </div>

        <div class="flex items-center gap-2 md:gap-3 relative">
            <a href="create_activity" class="hidden sm:flex items-center gap-2 bg-purple-600 text-white px-4 md:px-5 py-2 md:py-2.5 rounded-full font-bold text-xs md:text-sm hover:bg-purple-700 transition shadow-md active:scale-95">
                <span class="text-sm md:text-lg leading-none">➕</span> สร้าง
            </a>

            <button onclick="toggleProfileMenu()" class="flex items-center gap-2 text-xs md:text-sm font-bold text-slate-600 bg-white px-3 py-2 md:px-5 md:py-2.5 rounded-full shadow-sm border border-slate-200 hover:bg-slate-50 transition active:scale-95">
                👤 <span class="hidden sm:inline"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                <span class="text-[10px] text-slate-400">▼</span>
            </button>
            <div id="profileDropdown" class="hidden absolute right-0 top-full mt-3 w-56 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-white overflow-hidden z-[100] transform transition-all">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">บัญชีของคุณ</p>
                    <p class="text-sm font-black text-slate-800 truncate"><?php echo htmlspecialchars($_SESSION["username"]); ?></p>
                </div>
                <a href="profile" class="block px-5 py-3.5 text-sm font-bold text-slate-600 hover:bg-purple-50 hover:text-purple-600 transition flex items-center gap-3"><span class="text-lg">📝</span> ดูโปรไฟล์</a>
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
                <a href="all_activities" class="px-5 py-4 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition flex items-center gap-3"><span class="text-xl">🔍</span> กิจกรรมทั้งหมด</a>
                <a href="my_activities" class="px-5 py-4 rounded-2xl font-bold text-purple-600 bg-purple-50 transition flex items-center gap-3"><span class="text-xl">📋</span> จัดการกิจกรรม</a>
                <a href="create_activity" class="px-5 py-4 mt-2 bg-purple-600 text-white rounded-2xl font-bold hover:bg-purple-700 transition flex items-center justify-center shadow-md">➕ สร้างกิจกรรม</a>
                <a href="search_users" class="px-5 py-4 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition flex items-center gap-3"><span class="text-xl">🔍</span> ค้นหาผู้ใช้</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white/90 backdrop-blur-md p-6 md:p-8 rounded-[2.5rem] shadow-sm border border-white mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">📋 กิจกรรมที่คุณจัด</h2>
                <p class="text-slate-500 font-medium mt-1">จัดการข้อมูลและอนุมัติผู้เข้าร่วมกิจกรรมของคุณ</p>
            </div>
            <div class="w-full sm:w-auto">
                <a href="create_activity" class="sm:hidden block text-center bg-purple-600 text-white px-6 py-3 rounded-full font-bold hover:bg-purple-700 transition shadow-lg">➕ สร้างเลย</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <?php if (isset($myActivities) && $myActivities && $myActivities->num_rows > 0): ?>
                <?php while ($row = $myActivities->fetch_assoc()): ?>

                    <div class="bg-white/90 backdrop-blur-md p-6 md:p-8 rounded-[2rem] shadow-sm border border-white flex flex-col hover:shadow-xl hover:border-purple-200 transition-all duration-300">
                        <div class="flex flex-col xl:flex-row justify-between items-start mb-6 gap-4">
                            <div class="flex-1 min-w-0 w-full cursor-pointer" onclick="window.location.href='view_activity?id=<?php echo $row['EventID']; ?>'">
                                <h4 class="text-2xl font-black text-slate-800 mb-2 break-all leading-tight hover:text-purple-600 transition"><?php echo htmlspecialchars($row["Title"]); ?></h4>
                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 w-fit">
                                    <p class="text-sm font-bold text-slate-500 flex items-center gap-2 mb-1">
                                        <span class="w-2 h-2 rounded-full bg-purple-500"></span> เริ่ม: <?php echo date('d M Y H:i', strtotime($row["StartDate"])); ?>
                                    </p>
                                    <p class="text-sm font-bold text-slate-500 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-red-400"></span> สิ้นสุด: <?php echo date('d M Y H:i', strtotime($row["EndDate"])); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-1.5 shrink-0 bg-slate-50 p-1.5 rounded-2xl border border-slate-200 shadow-inner overflow-x-auto hide-scrollbar">
                                <a href="edit_activity?id=<?php echo $row['EventID']; ?>" onclick="event.stopPropagation();" class="flex items-center gap-1.5 text-purple-600 hover:bg-white px-3.5 py-2.5 rounded-xl transition shadow-sm border border-transparent hover:border-purple-200 whitespace-nowrap text-xs font-bold">
                                    <span class="text-sm leading-none">✏️</span> แก้ไข
                                </a>
                                <a href="event_stats?id=<?php echo $row['EventID']; ?>" onclick="event.stopPropagation();" class="flex items-center gap-1.5 text-indigo-600 hover:bg-white px-3.5 py-2.5 rounded-xl transition shadow-sm border border-transparent hover:border-indigo-200 whitespace-nowrap text-xs font-bold">
                                    <span class="text-sm leading-none">📊</span> สถิติ
                                </a>
                                <a href="#" onclick="event.preventDefault(); event.stopPropagation(); confirmDeleteActivity(<?php echo $row['EventID']; ?>)" class="flex items-center gap-1.5 text-red-500 hover:bg-white px-3.5 py-2.5 rounded-xl transition shadow-sm border border-transparent hover:border-red-200 whitespace-nowrap text-xs font-bold">
                                    <span class="text-sm leading-none">🗑️</span> ลบ
                                </a>
                            </div>
                        </div>

                        <?php
                        $event_id = $row['EventID'];
                        $images = $model->getEventImages($event_id);
                        ?>

                        <?php if (count($images) > 0): ?>
                            <div onclick="window.location.href='view_activity?id=<?php echo $row['EventID']; ?>'"
                                class="relative w-full aspect-[21/9] mb-6 rounded-2xl overflow-hidden bg-slate-100 group shadow-inner">
                                <div id="carousel-<?php echo $event_id; ?>" class="flex w-full h-full overflow-x-hidden snap-x snap-mandatory scroll-smooth hide-scrollbar">
                                    <?php foreach ($images as $img_path): ?>
                                        <div class="w-full h-full flex-shrink-0 snap-center relative">
                                            <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>
                                            <img src="<?php echo $base_url . '/' . ltrim(htmlspecialchars($img_path), '/'); ?>" class="w-full h-full object-cover">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($images) > 1): ?>
                                    <button onclick="event.stopPropagation(); scrollCarousel('carousel-<?php echo $event_id; ?>', -1)" type="button" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-10 shadow-md">&#10094;</button>
                                    <button onclick="event.stopPropagation(); scrollCarousel('carousel-<?php echo $event_id; ?>', 1)" type="button" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-10 shadow-md">&#10095;</button>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="relative w-full aspect-[21/9] mb-6 rounded-2xl overflow-hidden bg-slate-100 shadow-inner flex items-center justify-center text-slate-400 font-bold">ไม่มีรูปภาพ</div>
                        <?php endif; ?>

                        <p class="text-slate-500 text-sm mb-6 flex-1 line-clamp-2 leading-relaxed"><?php echo nl2br(htmlspecialchars($row["Desciption"])); ?></p>

                        <div class="bg-slate-50 p-4 md:p-5 rounded-[1.5rem] border border-slate-200 mt-auto shadow-inner" onclick="event.stopPropagation();">
                            <h5 class="text-sm font-black mb-3 text-slate-800 flex items-center gap-2">👥 รายชื่อผู้เข้าร่วม</h5>
                            <?php $participants = $model->getParticipantsByEvent($row['EventID']); ?>

                            <?php if ($participants && $participants->num_rows > 0): ?>
                                <ul class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                                    <?php while ($p = $participants->fetch_assoc()): ?>
                                        <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-sm p-3 bg-white rounded-xl border border-slate-100 shadow-sm gap-3">
                                            <div class="flex flex-col min-w-0">
                                                <span class="text-slate-800 font-bold truncate">👤 <?php echo htmlspecialchars($p['Name']); ?></span>
                                                <span class="text-[10px] text-slate-400 truncate"><?php echo htmlspecialchars($p['Email']); ?></span>
                                            </div>

                                            <div class="flex gap-2 whitespace-nowrap">
                                                <?php
                                                $p_status = trim(strtolower($p['Status']));
                                                if ($p_status == 'pending'):
                                                ?>
                                                    <button onclick="openManageStatusModal(<?php echo $row['EventID']; ?>, <?php echo $p['UserID']; ?>, 'approve', '<?php echo htmlspecialchars($p['Name']); ?>')" class="bg-green-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-green-600 transition shadow-sm">✔️ อนุมัติ</button>
                                                    <button onclick="openManageStatusModal(<?php echo $row['EventID']; ?>, <?php echo $p['UserID']; ?>, 'reject', '<?php echo htmlspecialchars($p['Name']); ?>')" class="bg-red-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-600 transition shadow-sm">❌ ไม่อนุมัติ</button>
                                                <?php elseif ($p_status == 'approved'): ?>
                                                    <span class="text-orange-500 font-bold bg-orange-50 px-3 py-1.5 rounded-lg border border-orange-200 text-xs">⏳ รอยืนยัน OTP</span>
                                                <?php elseif ($p_status == 'checked_in' || $p_status == 'check_in'): ?>
                                                    <span class="text-blue-600 font-bold bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-200 text-xs">✨ เข้าร่วมสำเร็จ</span>
                                                <?php elseif ($p_status == 'rejected' || $p_status == 'rejected_hidden'): ?>
                                                    <span class="text-red-500 font-bold bg-red-50 px-3 py-1.5 rounded-lg border border-red-200 text-xs mr-2">❌ ไม่อนุมัติ</span>
                                                    <button onclick="openManageStatusModal(<?php echo $row['EventID']; ?>, <?php echo $p['UserID']; ?>, 'approve', '<?php echo htmlspecialchars($p['Name']); ?>')" class="bg-green-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-green-600 transition shadow-sm">✔️ อนุมัติใหม่</button>
                                                <?php else: ?>
                                                    <span class="text-slate-400 font-bold bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200 text-xs">⚠️ รอแก้ไขสถานะ</span>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-sm text-slate-400 font-medium text-center py-4 bg-white rounded-xl border border-dashed border-slate-200">ยังไม่มีผู้เข้าร่วม</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full bg-white/80 p-16 rounded-[2.5rem] border border-dashed border-slate-300 text-center shadow-sm backdrop-blur-sm">
                    <span class="text-5xl block mb-4">📭</span>
                    <p class="text-slate-500 mb-6 text-xl font-bold">คุณยังไม่ได้สร้างกิจกรรมใดๆ</p>
                    <a href="create_activity" class="inline-block bg-purple-600 text-white font-bold px-8 py-4 rounded-full hover:bg-purple-700 transition shadow-lg active:scale-95">➕ สร้างกิจกรรมใหม่</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="statusModal" class="hidden fixed inset-0 bg-slate-900/60 z-[999] flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl max-w-sm w-full text-center transform transition-all scale-100 border-t-8 border-green-500">
            <div id="modalIconBg" class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner border border-green-100">
                <span id="modalIconText" class="text-5xl">✅</span>
            </div>
            <h3 id="modalTitle" class="text-2xl font-black text-slate-800 mb-2">สำเร็จ!</h3>
            <p id="modalMessage" class="text-slate-500 mb-8 font-medium">ข้อความแจ้งเตือนของคุณ</p>
            <button onclick="closeStatusModal()" class="w-full py-4 bg-slate-900 text-white font-bold text-lg rounded-2xl hover:bg-purple-600 transition shadow-lg active:scale-95">ตกลง</button>
        </div>
    </div>

    <div id="deleteActivityModal" class="hidden fixed inset-0 bg-slate-900/60 z-[110] flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl max-w-sm w-full text-center border-t-8 border-red-500">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-100 text-4xl">🗑️</div>
            <h3 class="text-2xl font-black mb-2 text-slate-800">ยืนยันการลบ?</h3>
            <p class="text-slate-500 mb-8 font-medium text-sm">หากลบแล้วจะไม่สามารถกู้คืนข้อมูลได้อีก</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteActivityModal()" class="flex-1 py-4 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition">ยกเลิก</button>
                <button id="confirmDeleteActivityBtn" class="flex-1 py-4 bg-red-500 text-white font-bold rounded-2xl shadow-lg hover:bg-red-600 transition">ยืนยันลบ</button>
            </div>
        </div>
    </div>

    <div id="manageStatusModal" class="hidden fixed inset-0 bg-slate-900/60 z-[110] flex items-center justify-center backdrop-blur-sm p-4">
        <div id="statusModalBorder" class="bg-white p-8 rounded-[2.5rem] shadow-2xl max-w-sm w-full text-center border-t-8 transform transition-all">
            <div id="statusModalIconBg" class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border shadow-inner">
                <span id="statusModalIcon" class="text-4xl"></span>
            </div>
            <h3 id="statusModalTitle" class="text-2xl font-black text-slate-800 mb-2"></h3>
            <p id="statusModalDesc" class="text-slate-500 mb-8 font-medium"></p>
            <div class="flex gap-3">
                <button onclick="closeManageStatusModal()" class="flex-1 py-4 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition">ยกเลิก</button>
                <button id="confirmStatusBtn" class="flex-1 py-4 text-white font-bold rounded-2xl transition shadow-lg"></button>
            </div>
        </div>
    </div>

    <script>
        function scrollCarousel(id, dir) {
            const el = document.getElementById(id);
            el.scrollBy({
                left: el.clientWidth * dir,
                behavior: 'smooth'
            });
        }

        function showStatusModal(title, message, icon = '✅', type = 'success') {
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
            const url = new URL(window.location);
            url.searchParams.delete('deleted');
            url.searchParams.delete('status');
            url.searchParams.delete('msg');
            window.history.replaceState(null, null, url);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('deleted') === '1') {
                showStatusModal('ลบกิจกรรมสำเร็จ!', 'กิจกรรมของคุณถูกลบออกจากระบบเรียบร้อยแล้ว', '🗑️', 'success');
            } else if (urlParams.get('status') === 'success') {
                if (urlParams.get('msg') === 'approved') showStatusModal('อนุมัติสำเร็จ!', 'ผู้ใช้คนนี้สามารถเข้าร่วมกิจกรรมได้แล้ว', '✅', 'success');
                else if (urlParams.get('msg') === 'rejected') showStatusModal('ปฏิเสธสำเร็จ', 'ลบผู้ใช้ออกจากรายการเรียบร้อยแล้ว', '❌', 'success');
            } else if (urlParams.get('status') === 'error') {
                if (urlParams.get('msg') === 'full') showStatusModal('กิจกรรมเต็มแล้ว', 'ไม่สามารถอนุมัติเพิ่มได้ เนื่องจากจำนวนคนเต็ม', '⚠️', 'error');
                else showStatusModal('เกิดข้อผิดพลาด', 'ระบบไม่สามารถทำรายการได้ กรุณาลองใหม่', '❌', 'error');
            }
        });

        let activityIdToDelete = null;

        function confirmDeleteActivity(id) {
            activityIdToDelete = id;
            document.getElementById('deleteActivityModal').classList.remove('hidden');
        }

        function closeDeleteActivityModal() {
            document.getElementById('deleteActivityModal').classList.add('hidden');
            activityIdToDelete = null;
        }
        document.getElementById('confirmDeleteActivityBtn').onclick = function() {
            if (activityIdToDelete) window.location.href = 'delete_activity?id=' + activityIdToDelete;
        };

        let statusActionInfo = null;

        function openManageStatusModal(eventId, userId, action, userName) {
            statusActionInfo = {
                eventId,
                userId,
                action
            };
            const modal = document.getElementById('manageStatusModal');
            const border = document.getElementById('statusModalBorder');
            const iconBg = document.getElementById('statusModalIconBg');
            const icon = document.getElementById('statusModalIcon');
            const title = document.getElementById('statusModalTitle');
            const desc = document.getElementById('statusModalDesc');
            const btn = document.getElementById('confirmStatusBtn');

            border.classList.remove('border-green-500', 'border-red-500');
            iconBg.classList.remove('bg-green-50', 'bg-red-50', 'border-green-100', 'border-red-100');
            btn.classList.remove('bg-green-500', 'bg-red-500');

            if (action === 'approve') {
                border.classList.add('border-green-500');
                iconBg.classList.add('bg-green-50', 'border-green-100');
                icon.innerText = '✔️';
                title.innerText = 'ยืนยันการอนุมัติ?';
                desc.innerText = `ต้องการอนุมัติคุณ ${userName} ใช่หรือไม่?`;
                btn.innerText = 'ยืนยันอนุมัติ';
                btn.classList.add('bg-green-500');
            } else {
                border.classList.add('border-red-500');
                iconBg.classList.add('bg-red-50', 'border-red-100');
                icon.innerText = '❌';
                title.innerText = 'ยืนยันการไม่อนุมัติ?';
                desc.innerText = `ต้องการลบคำขอของคุณ ${userName} ใช่หรือไม่?`;
                btn.innerText = 'ยืนยันไม่อนุมัติ';
                btn.classList.add('bg-red-500');
            }
            modal.classList.remove('hidden');
        }

        function closeManageStatusModal() {
            document.getElementById('manageStatusModal').classList.add('hidden');
        }
        document.getElementById('confirmStatusBtn').onclick = function() {
            if (statusActionInfo) {
                const {
                    eventId,
                    userId,
                    action
                } = statusActionInfo;
                window.location.href = `manage_status?event_id=${eventId}&user_id=${userId}&action=${action}`;
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
    </script>
</body>

</html>