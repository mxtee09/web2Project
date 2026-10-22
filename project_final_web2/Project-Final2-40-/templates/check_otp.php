<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตรวจสอบรหัส OTP</title>
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

<body class="min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-10 rounded-[3rem] shadow-2xl w-full max-w-md border border-white text-center relative z-10">

        <div class="w-24 h-24 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-purple-100 text-4xl shadow-inner">
            🛡️
        </div>

        <h2 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">ตรวจสอบการเข้างาน</h2>
        <p class="text-slate-500 mb-8 font-medium">กรุณากรอกรหัส OTP 6 หลักจากผู้เข้าร่วม</p>

        <form id="otpVerifyForm" class="space-y-6">
            <input type="text" id="inputOtp" maxlength="6" placeholder="000000"
                class="w-full text-center text-5xl font-black tracking-[0.3em] py-6 bg-slate-50 border-2 border-dashed border-slate-300 rounded-[2rem] focus:border-purple-500 focus:bg-white outline-none transition text-slate-800 shadow-inner">

            <button type="submit" class="w-full bg-slate-900 text-white font-bold py-5 rounded-full text-xl shadow-lg hover:bg-purple-600 transition active:scale-95 mt-4">
                🚀 ยืนยันรหัสผ่าน
            </button>
        </form>

        <a href="dashboard" class="inline-block mt-8 text-slate-400 font-bold hover:text-purple-600 transition">⬅️ กลับหน้าหลัก</a>
    </div>

    <script>
        document.getElementById('otpVerifyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const inputOtp = document.getElementById('inputOtp').value;

            if (inputOtp.length === 6) {
                alert('ตรวจสอบรหัสถูกต้อง! (ระบบนี้ออกแบบไว้เชื่อมต่อกับฐานข้อมูล)');
                window.location.href = 'dashboard';
            } else {
                alert('รหัส OTP ไม่ถูกต้องหรือกรอกไม่ครบ');
            }
        });
    </script>
</body>

</html>