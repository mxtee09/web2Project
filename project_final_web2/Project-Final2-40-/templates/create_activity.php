<?php date_default_timezone_set('Asia/Bangkok'); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างกิจกรรม - ActiSpace</title>
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

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="min-h-screen pb-12 relative flex flex-col items-center">

    <nav class="w-full flex justify-between items-center px-6 md:px-12 py-5 bg-white/80 backdrop-blur-xl sticky top-0 z-50 border-b border-white shadow-sm mb-8">
        <div class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500 flex items-center gap-2 hover:opacity-80 transition">
            <a href="dashboard"><span class="text-4xl text-purple-600">🚀</span> ActiSpace</a>
        </div>
        <a href="my_activities" class="bg-white text-slate-500 px-6 py-2.5 rounded-full font-bold shadow-sm border border-slate-200 hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition">
            ✕ ปิดหน้าต่าง
        </a>
    </nav>

    <div class="bg-white/95 backdrop-blur-xl p-8 md:p-10 rounded-[3rem] shadow-xl border border-white w-full max-w-2xl relative z-10 mx-4">

        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-purple-100 shadow-inner">
                <span class="text-4xl">✨</span>
            </div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">สร้างกิจกรรมใหม่</h2>
            <p class="text-slate-500 font-medium mt-1">เริ่มโปรเจกต์ดีๆ ของคุณได้เลยที่นี่</p>
        </div>

        <?php if (isset($msg) && $msg) echo "<div class='bg-red-50 text-red-600 p-4 rounded-2xl mb-6 border border-red-100 text-center font-bold'>" . htmlspecialchars($msg) . "</div>"; ?>

        <form action="create_activity" method="POST" enctype="multipart/form-data" class="space-y-5">
            <div>
                <label class="block text-sm font-bold mb-2 text-slate-700">ชื่อกิจกรรม</label>
                <input type="text" name="title" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition font-medium text-slate-800">
            </div>

            <div>
                <label class="block text-sm font-bold mb-2 text-slate-700">รายละเอียด</label>
                <textarea name="description" rows="5" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition font-medium resize-none text-slate-800"></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold mb-2 text-slate-700">จำนวนคนที่รับได้สูงสุด (คน)</label>
                <input type="number" name="max_people" required min="1" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition font-medium text-slate-800">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <?php $current_datetime = date('Y-m-d\TH:i'); ?>
                <div>
                    <label class="block text-sm font-bold mb-2 text-slate-700">เวลาเริ่ม</label>
                    <input type="datetime-local" id="start_date" name="start_date" min="<?php echo $current_datetime; ?>" required onchange="document.getElementById('end_date').min = this.value;" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition font-medium text-slate-600 appearance-none">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2 text-slate-700">เวลาสิ้นสุด</label>
                    <input type="datetime-local" id="end_date" name="end_date" min="<?php echo $current_datetime; ?>" required class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition font-medium text-slate-600 appearance-none">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 mt-6">
                <label class="block text-sm font-bold mb-3 text-slate-700">อัปโหลดรูปภาพ (เลือกหลายรูปได้)</label>
                <div class="bg-slate-50 p-8 rounded-[2rem] border-2 border-dashed border-slate-300 text-center hover:border-purple-400 hover:bg-purple-50/50 transition-colors cursor-pointer relative shadow-inner">
                    <span class="text-4xl block mb-3">📸</span>
                    <p class="text-slate-600 font-bold mb-2">คลิกเพื่อเลือกไฟล์ หรือลากไฟล์มาวาง</p>
                    <p class="text-xs text-slate-400 font-medium">* เลือกไฟล์เพื่อเพิ่มรูปภาพใหม่</p>
                    <input type="file" id="imageInput" name="images[]" multiple accept="image/jpeg, image/png, image/gif, image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div id="previewContainer" class="flex overflow-x-auto gap-3 items-center justify-center mt-5 hide-scrollbar"></div>
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-bold py-5 rounded-full hover:bg-purple-600 transition shadow-xl mt-8 text-lg active:scale-95">
                🚀 บันทึกและสร้างกิจกรรม
            </button>
        </form>

        <div class="mt-8 text-center pt-6 border-t border-slate-100">
            <a href="my_activities" class="inline-flex items-center text-slate-400 hover:text-purple-600 font-bold text-sm transition">
                <span class="mr-2">⬅️</span> ย้อนกลับหน้าจัดการกิจกรรม
            </a>
        </div>

    </div>

    <div id="imageModal" class="hidden fixed inset-0 bg-slate-900/90 z-[120] flex items-center justify-center p-4 backdrop-blur-sm">
        <span class="absolute top-6 right-6 text-white text-4xl cursor-pointer hover:text-purple-400 transition" onclick="closeModal()">&times;</span>
        <img id="modalImage" class="max-w-full max-h-[90vh] rounded-2xl shadow-2xl object-contain border-4 border-white/10">
    </div>

    <?php if (isset($success) && $success): ?>
        <div id="successModal" class="fixed inset-0 bg-slate-900/60 z-[120] flex items-center justify-center backdrop-blur-sm p-4">
            <div class="bg-white p-10 rounded-[3rem] shadow-2xl max-w-sm w-full mx-4 text-center transform transition-all border-t-[12px] border-green-500">
                <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner border border-green-100">
                    <span class="text-5xl">✅</span>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-2">สร้างกิจกรรมสำเร็จ!</h3>
                <p class="text-slate-500 mb-8 font-medium">ระบบได้บันทึกกิจกรรมของคุณเรียบร้อยแล้ว</p>
                <button onclick="window.location.href='all_activities'" class="w-full py-4 bg-slate-900 text-white font-bold text-lg rounded-2xl hover:bg-purple-600 transition shadow-lg active:scale-95">ตกลง</button>
            </div>
        </div>
        <script>
            if (window.history.replaceState) window.history.replaceState(null, null, window.location.href);
        </script>
    <?php endif; ?>

    <script>
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');
        let selectedFiles = [];

        imageInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            files.forEach(file => {
                if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file);
                }
            });
            updateInputAndRender();
        });

        function updateInputAndRender() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            imageInput.files = dt.files;
            previewContainer.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative w-24 h-24 flex-shrink-0 group z-20';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover rounded-2xl border-2 border-white shadow-sm cursor-pointer hover:opacity-75 transition';
                    img.onclick = () => openModal(e.target.result);

                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '✕';
                    removeBtn.type = 'button';
                    removeBtn.className = 'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center text-xs font-bold opacity-0 group-hover:opacity-100 transition shadow-md hover:bg-red-600 z-30 cursor-pointer';
                    removeBtn.onclick = (event) => {
                        event.preventDefault();
                        selectedFiles.splice(index, 1);
                        updateInputAndRender();
                    };

                    div.appendChild(img);
                    div.appendChild(removeBtn);
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }

        function openModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>

</html>