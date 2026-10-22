<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กิจกรรมของ <?php echo htmlspecialchars($creator_info['Name']); ?></title>
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
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="min-h-screen pb-10 relative">

    <nav class="flex justify-between items-center px-4 sm:px-6 md:px-12 py-4 bg-white/90 backdrop-blur-xl sticky top-0 z-50 border-b border-white shadow-sm mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <div class="text-2xl md:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500 flex items-center gap-1 md:gap-2">
                <span class="text-3xl md:text-4xl text-purple-600">🚀</span><span class="hidden sm:inline ml-1">ActiSpace</span>
            </div>
        </div>
        <button onclick="window.close()" class="bg-slate-50 text-slate-600 px-5 py-2.5 rounded-full font-bold shadow-sm border border-slate-200 hover:bg-slate-100 transition text-sm">✕ ปิดหน้านี้</button>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-8 md:p-10 rounded-[2.5rem] shadow-xl shadow-purple-200 mb-8 relative overflow-hidden border-4 border-white/20">
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center text-4xl border-2 border-white/50 backdrop-blur-sm shrink-0 shadow-inner">
                    <?php 
                        if ($creator_info['Gender'] == 'Male') echo '👨';
                        elseif ($creator_info['Gender'] == 'Female') echo '👩';
                        else echo '🧑';
                    ?>
                </div>
                <div class="text-center md:text-left">
                    <h2 class="text-2xl md:text-4xl font-black text-white mb-2 leading-tight tracking-tight">กิจกรรมของ <?php echo htmlspecialchars($creator_info['Name']); ?></h2>
                    <p class="text-purple-100 font-medium bg-white/10 inline-block px-4 py-1.5 rounded-full border border-white/20 backdrop-blur-md">บัญชี: <?php echo htmlspecialchars($creator_info['Email']); ?></p>
                </div>
            </div>
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            <?php if (isset($activities) && $activities && $activities->num_rows > 0): ?>
                <?php while ($activity = $activities->fetch_assoc()): ?>
                    <div class="bg-white/90 backdrop-blur-md rounded-[1.5rem] md:rounded-[2rem] shadow-sm flex flex-col hover:shadow-xl hover:-translate-y-1 border border-white transition-all duration-300 overflow-hidden group">
                        
                        <?php
                        $event_id = $activity['EventID'];
                        $images = $model->getEventImages($event_id);
                        ?>
                        <div onclick="window.location.href='view_activity?id=<?php echo $activity['EventID']; ?>'" class="cursor-pointer relative w-full aspect-[4/3] bg-slate-100 overflow-hidden shrink-0">
                            <?php if (count($images) > 0): ?>
                                <div id="carousel-usr-<?php echo $event_id; ?>" class="flex w-full h-full overflow-x-hidden snap-x snap-mandatory scroll-smooth hide-scrollbar">
                                    <?php foreach ($images as $img_path): ?>
                                        <div class="w-full h-full flex-shrink-0 snap-center relative">
                                            <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>
                                            <img src="<?php echo $base_url . '/' . ltrim(htmlspecialchars($img_path), '/'); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($images) > 1): ?>
                                    <button onclick="event.stopPropagation(); scrollCarousel('carousel-usr-<?php echo $event_id; ?>', -1)" type="button" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-10 shadow-md">&#10094;</button>
                                    <button onclick="event.stopPropagation(); scrollCarousel('carousel-usr-<?php echo $event_id; ?>', 1)" type="button" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-10 shadow-md">&#10095;</button>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-50 font-bold">ไม่มีรูปภาพ</div>
                            <?php endif; ?>
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <h4 class="text-lg md:text-xl font-black mb-2 text-slate-800 break-all leading-tight line-clamp-2"><?php echo htmlspecialchars($activity['Title']); ?></h4>
                            <div class="bg-slate-50 p-3 rounded-2xl mb-4 border border-slate-100 mt-auto">
                                <p class="text-xs font-bold text-slate-700 flex items-center gap-2 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-purple-500"></span> เริ่ม: <?php echo date('d M Y - H:i', strtotime($activity['StartDate'])); ?>
                                </p>
                            </div>
                            
                            <a href="view_activity?id=<?php echo $activity['EventID']; ?>" class="w-full text-center bg-purple-600 text-white font-bold py-3.5 rounded-xl hover:bg-purple-700 transition shadow-md text-sm mt-auto active:scale-95">
                                🔍 ดูรายละเอียดกิจกรรม
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function scrollCarousel(carouselId, direction) {
            const carousel = document.getElementById(carouselId);
            if (carousel) {
                const scrollAmount = carousel.clientWidth;
                carousel.scrollBy({ left: scrollAmount * direction, behavior: 'smooth' });
            }
        }
    </script>
</body>
</html>