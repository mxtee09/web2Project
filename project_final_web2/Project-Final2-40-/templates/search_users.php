<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาผู้ใช้ - ActiSpace</title>
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
    </style>
</head>

<body class="min-h-screen pb-10 relative">

    <nav class="flex justify-between items-center px-4 sm:px-6 md:px-12 py-4 bg-white/90 backdrop-blur-xl sticky top-0 z-50 border-b border-white shadow-sm mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <div class="text-2xl md:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500 flex items-center gap-1 md:gap-2">
                <a href="<?php echo isset($_SESSION['user_id']) ? 'dashboard' : 'login'; ?>" class="flex items-center"><span class="text-3xl md:text-4xl text-purple-600">🚀</span><span class="hidden sm:inline ml-1">ActiSpace</span></a>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard" class="bg-slate-50 text-slate-600 px-5 py-2.5 rounded-full font-bold shadow-sm border border-slate-200 hover:bg-slate-100 transition text-sm">⬅️ กลับหน้าหลัก</a>
            <?php else: ?>
                <a href="login" class="bg-purple-600 text-white px-6 py-2.5 rounded-full font-bold shadow-sm hover:bg-purple-700 transition text-sm">เข้าสู่ระบบ</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white/90 backdrop-blur-md p-6 md:p-8 rounded-[2rem] shadow-sm border border-white mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-5">
                <div class="text-center lg:text-left w-full lg:w-1/3">
                    <h2 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight mb-2">ค้นหาผู้ใช้ 👥</h2>
                    <p class="text-slate-500 font-medium text-sm">พิมพ์ชื่อหรืออีเมลเพื่อค้นหาและดูกิจกรรมของพวกเขา</p>
                </div>

                <form method="GET" action="search_users" class="w-full lg:w-2/3 flex gap-3">
                    <input type="text" name="search" placeholder="🔍 ค้นหาด้วยชื่อ หรือ อีเมล..." value="<?php echo htmlspecialchars($search); ?>" class="px-5 py-4 bg-slate-50 text-slate-800 focus:outline-none font-medium border border-slate-200 rounded-2xl w-full focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition">
                    <button type="submit" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-purple-600 transition shadow-md whitespace-nowrap">ค้นหา</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            <?php if (isset($users) && $users && $users->num_rows > 0): ?>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <div class="bg-white/90 backdrop-blur-md rounded-[2rem] p-6 shadow-sm border border-white flex flex-col hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        
                        <div class="w-16 h-16 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-3xl mx-auto mb-4 shadow-inner">
                            <?php 
                                if ($user['Gender'] == 'Male') echo '👨';
                                elseif ($user['Gender'] == 'Female') echo '👩';
                                else echo '🧑';
                            ?>
                        </div>
                        
                        <div class="text-center mb-6 flex-1">
                            <h3 class="text-lg font-black text-slate-800 break-all leading-tight mb-1"><?php echo htmlspecialchars($user['Name']); ?></h3>
                            <p class="text-xs text-slate-400 font-medium break-all bg-slate-50 inline-block px-3 py-1 rounded-full border border-slate-100"><?php echo htmlspecialchars($user['Email']); ?></p>
                            
                            <div class="mt-4 flex items-center justify-center gap-4 text-sm font-bold text-slate-600">
                                <span class="bg-purple-50 text-purple-600 px-3 py-1.5 rounded-xl border border-purple-100">อายุ <?php echo htmlspecialchars($user['Age']); ?> ปี</span>
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-100 border-dashed">
                                <?php if ($user['event_count'] > 0): ?>
                                    <p class="text-sm font-black text-indigo-600">จัดกิจกรรม: <?php echo $user['event_count']; ?> รายการ</p>
                                <?php else: ?>
                                    <p class="text-sm font-bold text-slate-400">ไม่มีกิจกรรมที่สร้าง</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ($user['event_count'] > 0): ?>
                            <a href="user_activities?id=<?php echo $user['UserID']; ?>" target="_blank" class="w-full text-center bg-purple-600 text-white font-bold py-3.5 rounded-xl hover:bg-purple-700 transition shadow-md text-sm mt-auto active:scale-95">
                                📋 ดูกิจกรรมทั้งหมด
                            </a>
                        <?php else: ?>
                            <button disabled class="w-full bg-slate-100 text-slate-400 font-bold py-3.5 rounded-xl cursor-not-allowed text-sm mt-auto border border-slate-200">
                                🚫 ดูกิจกรรมไม่ได้
                            </button>
                        <?php endif; ?>

                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full bg-white/80 border border-dashed border-slate-300 rounded-[2.5rem] text-center py-20 shadow-sm backdrop-blur-sm">
                    <span class="text-5xl block mb-4">📭</span>
                    <h3 class="text-2xl font-black text-slate-800 mb-2">ไม่พบผู้ใช้งาน</h3>
                    <p class="text-slate-500 font-medium">ลองเปลี่ยนคำค้นหาใหม่ดูสิ</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>