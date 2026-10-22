<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
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

<body class="min-h-screen flex items-center justify-center p-4 relative">
    <div class="hero-wave"></div>

    <div class="bg-white/80 backdrop-blur-md p-10 rounded-[2.5rem] shadow-2xl border border-white w-full max-w-md relative z-10">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500">ยินดีต้อนรับกลับ</h2>
            <p class="text-slate-500 font-medium">เข้าสู่ระบบเพื่อจัดการกิจกรรมของคุณ</p>
        </div>

        <?php if (!empty($error_msg)): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-sm text-center border border-red-100 font-bold"><?php echo $error_msg; ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['register']) && $_GET['register'] == 'success'): ?>
            <div class="bg-green-50 text-green-600 p-4 rounded-2xl mb-6 text-sm text-center border border-green-100 font-bold">🎉 สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ</div>
        <?php endif; ?>

        <form action="login" method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-bold mb-2 text-slate-700">อีเมล</label>
                <input type="email" name="email" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white transition outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-slate-700">รหัสผ่าน</label>
                <input type="password" name="password" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white transition outline-none">
            </div>
            <button type="submit" class="w-full bg-purple-600 text-white font-bold py-4 rounded-full hover:bg-purple-700 transition shadow-lg shadow-purple-200 mt-6 active:scale-95">เข้าสู่ระบบ</button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-8 font-medium">ยังไม่มีบัญชี? <a href="register" class="text-purple-600 hover:text-purple-800 font-bold transition">สมัครสมาชิกเลย</a></p>
        <div class="mt-6 pt-6 border-t border-slate-100 text-center">
            <a href="search_users" class="inline-flex items-center justify-center w-full bg-slate-50 text-indigo-600 font-bold py-4 rounded-xl hover:bg-indigo-50 hover:border-indigo-200 transition border border-slate-200 shadow-sm gap-2 active:scale-95">
                <span class="text-xl">🔍</span> ค้นหาผู้ใช้และดูกิจกรรม
            </a>
        </div>
    </div>
</body>

</html>