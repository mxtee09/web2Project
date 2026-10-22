<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - ActiSpace</title>
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

        .hero-wave {
            position: fixed;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 50vh;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(139, 92, 246, 0.6) 100%);
            clip-path: polygon(100% 0%, 100% 100%, 0% 100%, 0% 85%, 15% 80%, 35% 90%, 55% 70%, 75% 85%, 85% 60%);
            z-index: -1;
        }
    </style>
</head>

<body class="min-h-screen relative overflow-x-hidden">

    <div class="hero-wave"></div>

    <nav class="flex justify-between items-center px-8 md:px-16 py-5 bg-white/70 backdrop-blur-xl sticky top-0 z-50 shadow-sm border-b border-white">
        <div class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500 flex items-center gap-2 hover:opacity-80 transition">
            <a href="dashboard"><span class="text-4xl text-purple-600">🚀</span> ActiSpace</a>
        </div>

        <div class="hidden md:flex gap-2 p-1.5 bg-slate-100/80 backdrop-blur-md border border-slate-200/50 rounded-full shadow-inner">
            <a href="#" class="bg-white text-purple-600 px-8 py-3 rounded-full text-base font-bold shadow-sm transition">หน้าหลัก</a>
            <a href="all_activities" class="text-slate-600 hover:text-purple-600 hover:bg-white px-8 py-3 rounded-full text-base font-bold transition">สำรวจกิจกรรม</a>
            <a href="#" class="text-slate-600 hover:text-purple-600 hover:bg-white px-8 py-3 rounded-full text-base font-bold transition">ติดต่อเรา</a>
        </div>

        <a href="login" class="bg-purple-600 text-white px-8 py-3.5 rounded-full font-bold text-base hover:bg-purple-700 transition shadow-lg shadow-purple-200 active:scale-95">
            เข้าสู่ระบบ
        </a>
    </nav>

    <main class="max-w-7xl mx-auto px-8 md:px-16 pt-20 md:pt-32 pb-20 relative z-10">
        <div class="max-w-3xl bg-white/40 p-10 rounded-[3rem] backdrop-blur-md border border-white/60 shadow-xl">
            <span class="inline-block px-5 py-2 mb-6 text-sm font-bold text-indigo-700 bg-indigo-100 rounded-full border border-indigo-200">
                ยินดีต้อนรับสู่พื้นที่ของคนมีของ ✨
            </span>
            <h1 class="text-6xl md:text-8xl font-black text-slate-900 mb-8 leading-[1.1]">
                ปลุกพลัง <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">กิจกรรมชั้นเยี่ยม</span>
            </h1>

            <p class="text-xl md:text-2xl text-slate-700 mb-12 font-medium max-w-xl leading-relaxed">
                <?= htmlspecialchars($welcome_message) ?> ค้นหาประสบการณ์ใหม่ จัดการกิจกรรมของคุณได้ง่ายๆ ในที่เดียว
            </p>

            <div class="flex flex-wrap gap-5">
                <a href="dashboard" class="bg-slate-900 text-white px-10 py-5 rounded-full font-bold text-xl hover:bg-purple-600 transition shadow-xl active:scale-95">
                    🚀 เริ่มต้นใช้งานเลย
                </a>
                <a href="all_activities" class="bg-white text-slate-800 border-2 border-slate-200 px-10 py-5 rounded-full font-bold text-xl hover:border-purple-300 hover:bg-purple-50 transition active:scale-95">
                    ดูกิจกรรมทั้งหมด
                </a>
            </div>
        </div>
    </main>

</body>

</html>