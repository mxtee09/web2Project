<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ของฉัน - ActiSpace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background-color: #f3f4f6;
            background-image:
                radial-gradient(circle at 15% 50%, rgba(139, 92, 246, 0.12), transparent 40%),
                radial-gradient(circle at 85% 30%, rgba(99, 102, 241, 0.12), transparent 40%),
                linear-gradient(to right, rgba(200, 200, 200, 0.25) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(200, 200, 200, 0.25) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 40px 40px, 40px 40px;
            background-attachment: fixed;
        }

        /* ตกแต่งแถบเลื่อนสำหรับประวัติกิจกรรม */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="min-h-screen pb-10 relative">

    <nav class="flex justify-between items-center px-6 md:px-12 py-5 bg-white/80 backdrop-blur-xl sticky top-0 z-50 border-b border-white shadow-sm mb-8">
        <div class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500 flex items-center gap-2 hover:opacity-80 transition">
            <a href="dashboard"><span class="text-4xl text-purple-600">🚀</span> ActiSpace</a>
        </div>
        <a href="dashboard" class="bg-white text-slate-600 px-6 py-2.5 rounded-full font-bold shadow-sm border border-slate-200 hover:bg-slate-50 transition">
            ⬅️ กลับแดชบอร์ด
        </a>
    </nav>

    <div class="max-w-3xl mx-auto px-4">

        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-10 md:p-14 rounded-[3rem] text-center relative overflow-hidden mb-8 border-4 border-white/30 shadow-xl shadow-purple-200">
            <div class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white/50 shadow-inner backdrop-blur-md">
                <span class="text-6xl">👤</span>
            </div>
            <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight leading-tight mb-2">
                <?php echo htmlspecialchars($user_info['Name']); ?>
            </h2>
            <p class="text-purple-200 font-medium text-lg mb-6"><?php echo htmlspecialchars($user_info['Email']); ?></p>

            <span class="inline-block bg-white/20 text-white backdrop-blur-md px-6 py-2 rounded-full font-bold border border-white/30 shadow-sm">
                <?php echo ($user_info['Role'] == 'creator') ? '👑 ผู้จัดกิจกรรม (Creator)' : '🏃‍♂️ ผู้เข้าร่วมกิจกรรม (Participant)'; ?>
            </span>

            <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-indigo-400/30 rounded-full blur-xl"></div>
        </div>

        <div class="bg-white/90 backdrop-blur-md p-8 md:p-10 rounded-[3rem] shadow-sm border border-white">
            <h3 class="text-xl font-black text-slate-800 mb-6 flex items-center gap-2 border-b border-slate-100 pb-4">
                <span>📝</span> ข้อมูลส่วนตัว
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-200 shadow-inner">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">เพศ (Gender)</p>
                    <p class="text-xl font-black text-purple-600">
                        <?php
                        if ($user_info['Gender'] == 'Male') echo '👨 ชาย (Male)';
                        elseif ($user_info['Gender'] == 'Female') echo '👩 หญิง (Female)';
                        else echo '🧑 อื่นๆ (Other)';
                        ?>
                    </p>
                </div>

                <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-200 shadow-inner">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">อายุ (Age)</p>
                    <p class="text-xl font-black text-purple-600">🎂 <?php echo htmlspecialchars($user_info['Age']); ?> ปี</p>
                </div>

                <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-200 shadow-inner sm:col-span-2">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">อาชีพ (Job)</p>
                    <p class="text-xl font-black text-purple-600">💼 <?php echo htmlspecialchars($user_info['Job'] ?? 'ไม่ระบุ'); ?></p>
                </div>
            </div>
            
            <h3 class="text-xl font-black text-slate-800 mb-6 mt-12 flex items-center gap-2 border-b border-slate-100 pb-4">
                <span>🕒</span> ประวัติกิจกรรมของฉัน
            </h3>

            <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                <?php if (!empty($history)): ?>
                    <?php foreach ($history as $act): ?>
                        <div class="bg-slate-50 p-5 rounded-[2rem] border border-slate-200 shadow-inner flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:border-purple-300 transition-colors cursor-default">
                            <div class="min-w-0 flex-1">
                                <h4 class="font-black text-slate-800 text-lg truncate"><?php echo htmlspecialchars($act['Title']); ?></h4>
                                <p class="text-xs text-slate-500 mt-1 font-medium">
                                    จัดโดย: <span class="text-purple-600 font-bold"><?php echo htmlspecialchars($act['creator_name']); ?></span> 
                                    • วันที่: <?php echo date('d/m/Y', strtotime($act['StartDate'])); ?>
                                </p>
                            </div>
                            
                            <div class="shrink-0">
                                <?php 
                                $status = trim(strtolower($act['Status']));
                                if ($status == 'pending'): ?>
                                    <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-xs font-bold border border-yellow-200 shadow-sm">⏳ รออนุมัติ</span>
                                <?php elseif ($status == 'approved'): ?>
                                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-xs font-bold border border-green-200 shadow-sm">✅ อนุมัติแล้ว (รอเข้างาน)</span>
                                <?php elseif ($status == 'checked_in'): ?>
                                    <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-xs font-bold border border-blue-200 shadow-sm">✨ เข้าร่วมแล้ว</span>
                                <?php elseif ($status == 'rejected' || $status == 'rejected_hidden'): ?>
                                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-xs font-bold border border-red-200 shadow-sm">❌ ถูกปฏิเสธ</span>
                                <?php else: ?>
                                    <span class="bg-slate-200 text-slate-600 px-4 py-2 rounded-full text-xs font-bold shadow-sm">ไม่ทราบสถานะ</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-10 bg-slate-50 rounded-[2rem] border border-slate-200 border-dashed">
                        <span class="text-4xl mb-3 block">📭</span>
                        <p class="text-slate-500 font-bold">ยังไม่มีประวัติการขอเข้าร่วมกิจกรรม</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-10 text-center">
                <a href="logout" class="inline-block w-full sm:w-auto bg-red-50 text-red-500 font-bold px-10 py-4 rounded-full hover:bg-red-500 hover:text-white transition shadow-sm border border-red-100">
                    🚪 ออกจากระบบ
                </a>
            </div>
        </div>

    </div>
</body>

</html>