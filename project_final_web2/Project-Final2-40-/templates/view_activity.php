<?php date_default_timezone_set('Asia/Bangkok'); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดกิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background-color: #f8fafc;
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

<body class="min-h-screen flex flex-col items-center p-4 md:p-8">

    <div class="max-w-4xl w-full mt-4">
        <a href="javascript:history.back()" class="inline-flex items-center text-slate-500 font-bold bg-white px-6 py-3 rounded-full shadow-sm border border-slate-100 hover:text-purple-600 hover:border-purple-200 transition mb-6">
            <span class="mr-2">⬅️</span> กลับสู่หน้าก่อนหน้า
        </a>

        <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-xl border border-slate-100 w-full overflow-hidden">

            <?php
            $event_id = $activity['EventID'];
            $folder_path = "uploads/event_" . $event_id . "/";
            $server_dir = BASE_PATH . "/public/" . $folder_path;
            $images = [];
            if (is_dir($server_dir)) {
                $images = glob($server_dir . "*.{jpg,jpeg,png,gif,webp,JPG,JPEG,PNG,GIF,WEBP}", GLOB_BRACE);
            }
            ?>

            <?php if (count($images) > 0): ?>
                <div class="relative group mb-10">
                    <div id="carousel-view" class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar rounded-[2rem] shadow-lg border border-slate-100 scroll-smooth">
                        <?php foreach ($images as $img_path):
                            $web_path = $folder_path . basename($img_path);
                        ?>
                            <div class="w-full flex-shrink-0 snap-center aspect-video md:aspect-[21/9]">
                                <img src="<?php echo htmlspecialchars($web_path); ?>" class="w-full h-full object-cover">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (count($images) > 1): ?>
                        <button onclick="scrollCarousel(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white w-12 h-12 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-lg backdrop-blur-sm z-10">
                            &#10094;
                        </button>
                        <button onclick="scrollCarousel(1)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white w-12 h-12 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow-lg backdrop-blur-sm z-10">
                            &#10095;
                        </button>
                    <?php endif; ?>
                </div>
            <?php elseif (!empty($activity['picture1'])): ?>
                <div class="mb-10 rounded-[2rem] overflow-hidden shadow-lg border border-slate-100">
                    <img src="<?php echo htmlspecialchars($activity['picture1']); ?>" class="w-full aspect-video object-cover">
                </div>
            <?php endif; ?>

            <div class="mb-10 w-full min-w-0 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-black text-slate-800 mb-4 break-all tracking-tight leading-tight"><?php echo htmlspecialchars($activity['Title']); ?></h1>
                <p class="text-lg text-slate-500 font-medium">จัดโดย: <span class="text-purple-600 font-bold"><?php echo htmlspecialchars($creator_name ?? 'ไม่ระบุ'); ?></span></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-2xl shadow-sm">📅</div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">เริ่มต้น</p>
                        <p class="text-xl font-black text-slate-800"><?php echo date('d M Y - H:i', strtotime($activity['StartDate'])); ?> น.</p>
                    </div>
                </div>
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-2xl shadow-sm">⏳</div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">สิ้นสุด</p>
                        <p class="text-xl font-black text-slate-800"><?php echo date('d M Y - H:i', strtotime($activity['EndDate'])); ?> น.</p>
                    </div>
                </div>
            </div>

            <div class="w-full min-w-0">
                <h3 class="text-2xl font-black text-slate-800 mb-6">รายละเอียดกิจกรรม</h3>
                <div class="text-slate-600 leading-relaxed bg-slate-50 p-8 rounded-[2rem] border border-slate-100 text-lg break-all whitespace-pre-wrap font-medium"><?php echo nl2br(htmlspecialchars($activity['Desciption'])); ?></div>
            </div>

        </div>
    </div>

    <script>
        function scrollCarousel(dir) {
            const carousel = document.getElementById('carousel-view');
            if (carousel) {
                const scrollAmount = carousel.clientWidth;
                carousel.scrollBy({
                    left: scrollAmount * dir,
                    behavior: 'smooth'
                });
            }
        }
    </script>
</body>

</html>