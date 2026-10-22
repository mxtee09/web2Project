<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>404 ไม่พบหน้า</title>
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
        
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        html, body, h1, h2, h3, h4, h5, h6, p, span, a, div, label, button, input, textarea {
            word-break: keep-all !important;
            overflow-wrap: break-word !important;
            white-space: normal !important;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="text-center bg-white p-12 md:p-20 rounded-[3rem] shadow-xl border border-slate-100 max-w-2xl w-full">
        <h1 class="text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600 tracking-tighter mb-4 drop-shadow-sm">404</h1>
        <h2 class="text-3xl font-black text-slate-800 mb-4">อุ๊ปส์! ไม่พบหน้าที่คุณค้นหา</h2>
        <p class="text-lg text-slate-500 mb-10 font-medium max-w-md mx-auto">หน้าเว็บที่คุณกำลังพยายามเข้าถึงอาจถูกลบไปแล้ว หรือคุณอาจพิมพ์ URL ผิดพลาด</p>
        
        <a href="dashboard" class="inline-block bg-slate-900 text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-purple-600 transition shadow-xl active:scale-95">
            🏠 กลับสู่หน้าหลัก
        </a>
    </div>
</body>
</html>
