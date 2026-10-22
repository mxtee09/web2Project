<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background-color: #ffffff;
            background-image: linear-gradient(to right, #f1f1f1 1px, transparent 1px), linear-gradient(to bottom, #f1f1f1 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .hero-wave {
            position: fixed;
            bottom: 0;
            right: 0;
            width: 50%;
            height: 50vh;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.05) 0%, rgba(139, 92, 246, 0.4) 100%);
            clip-path: polygon(100% 0, 100% 100%, 0 100%);
            z-index: -1;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 py-10 relative">
    <div class="hero-wave"></div>

    <div class="bg-white/90 backdrop-blur-xl p-8 md:p-10 rounded-[2.5rem] shadow-2xl border border-white w-full max-w-xl relative z-10">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">สร้างบัญชีใหม่ ✨</h2>
            <p class="text-slate-500 mt-2 font-medium">เริ่มต้นจัดการกิจกรรมและประสบการณ์ดีๆ</p>
        </div>

        <?php if (!empty($error_msg)): ?><div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-sm text-center border border-red-100 font-bold"><?php echo $error_msg; ?></div><?php endif; ?>

        <form action="register" method="POST" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold mb-2 text-slate-700">ชื่อผู้ใช้ (Username)</label>
                    <input type="text" name="username" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2 text-slate-700">อีเมล (Email)</label>
                    <input type="email" name="email" required
                        pattern=".+@(gmail\.com|email\.com)$"
                        title="กรุณาใช้อีเมล @gmail.com หรือ @email.com เท่านั้น"
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold mb-2 text-slate-700">รหัสผ่าน (Password)</label>
                <input type="password" name="password" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition">
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold mb-2 text-slate-700">เพศ</label>
                    <select name="gender" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition appearance-none cursor-pointer">
                        <option value="Male">ชาย</option>
                        <option value="Female">หญิง</option>
                        <option value="Other">อื่นๆ</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2 text-slate-700">อายุ</label>
                    <input type="number" name="age" required min="1" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold mb-2 text-slate-700">อาชีพ</label>
                    <select name="job" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition appearance-none cursor-pointer">
                        <option value="" disabled selected>เลือกอาชีพ...</option>
                        <option value="Student">นักเรียน / นักศึกษา</option>
                        <option value="Private Employee">พนักงานบริษัทเอกชน</option>
                        <option value="Business Owner">เจ้าของธุรกิจ</option>
                        <option value="Freelance">อาชีพอิสระ</option>
                        <option value="Unemployed">อื่นๆ</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2 text-slate-700">ประเภทผู้ใช้งาน</label>
                    <select name="role" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition appearance-none cursor-pointer">
                        <option value="participant">ผู้เข้าร่วมกิจกรรม</option>
                        <option value="creator">ผู้สร้างกิจกรรม</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-full hover:bg-purple-600 transition-colors duration-300 shadow-lg mt-4 active:scale-95">สมัครสมาชิก</button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-8 font-medium">มีบัญชีอยู่แล้ว? <a href="login" class="text-purple-600 font-bold hover:underline">เข้าสู่ระบบ</a></p>
    </div>
</body>

</html>