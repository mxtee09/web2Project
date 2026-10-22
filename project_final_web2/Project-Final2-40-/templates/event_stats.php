<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สถิติผู้เข้าร่วมกิจกรรม</title>
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

<body class="min-h-screen p-4 md:p-8">
    <div class="max-w-5xl mx-auto">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 mb-10 gap-6 w-full min-w-0">
            <div class="w-full min-w-0 flex-1">
                <h2 class="text-3xl font-black text-slate-800 flex items-center gap-3">
                    <span class="text-4xl">📊</span> สถิติผู้เข้าร่วม
                </h2>
                <h3 class="text-xl text-purple-600 mt-2 font-bold break-all"><?php echo htmlspecialchars($eventTitle); ?></h3>
            </div>
            <a href="my_activities" class="shrink-0 bg-slate-50 text-slate-600 font-bold border border-slate-200 px-8 py-4 rounded-full hover:bg-slate-100 transition whitespace-nowrap shadow-sm">
                ⬅️ กลับหน้าจัดการ
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="text-xl font-black mb-6 border-b border-slate-100 pb-4 flex items-center gap-2 text-slate-800">
                    <span class="text-2xl">👫</span> เพศ
                </h3>
                <table class="w-full">
                    <?php if (isset($statistics['gender']) && $statistics['gender']->num_rows > 0): ?>
                        <?php while ($row = $statistics['gender']->fetch_assoc()): ?>
                            <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50 transition group">
                                <td class="py-5 px-4 text-slate-600 font-bold"><?php echo htmlspecialchars($row['Gender']); ?></td>
                                <td class="py-5 px-4 text-right font-black text-purple-600 text-2xl"><?php echo $row['count']; ?> <span class="text-sm text-slate-400 font-medium">คน</span></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center text-slate-400 py-10 font-medium bg-slate-50 rounded-2xl">ยังไม่มีข้อมูลผู้เข้าร่วม</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="text-xl font-black mb-6 border-b border-slate-100 pb-4 flex items-center gap-2 text-slate-800">
                    <span class="text-2xl">🎂</span> ช่วงอายุ
                </h3>
                <table class="w-full">
                    <?php if (isset($statistics['age']) && $statistics['age']->num_rows > 0): ?>
                        <?php while ($row = $statistics['age']->fetch_assoc()): ?>
                            <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50 transition group">
                                <td class="py-5 px-4 text-slate-600 font-bold">อายุ <?php echo htmlspecialchars($row['AgeRange']); ?> ปี</td>
                                <td class="py-5 px-4 text-right font-black text-purple-600 text-2xl"><?php echo $row['count']; ?> <span class="text-sm text-slate-400 font-medium">คน</span></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center text-slate-400 py-10 font-medium bg-slate-50 rounded-2xl">ยังไม่มีข้อมูลผู้เข้าร่วม</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>

            <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100 md:col-span-2">
                <h3 class="text-xl font-black mb-8 border-b border-slate-100 pb-4 flex items-center gap-2 text-slate-800">
                    <span class="text-2xl">💼</span> แยกตามอาชีพ
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <?php if (isset($statistics['job']) && $statistics['job']->num_rows > 0): ?>
                        <?php while ($row = $statistics['job']->fetch_assoc()): ?>
                            <div class="flex justify-between items-center p-6 bg-slate-50 rounded-[1.5rem] border border-slate-200 hover:border-purple-300 hover:shadow-md transition">
                                <span class="text-slate-700 font-bold text-sm leading-tight pr-2"><?php echo htmlspecialchars($row['Job']); ?></span>
                                <span class="font-black text-purple-600 bg-white px-5 py-2.5 rounded-xl shadow-sm border border-slate-100 text-xl"><?php echo $row['count']; ?></span>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center text-slate-400 py-12 font-medium bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                            ยังไม่มีข้อมูลผู้เข้าร่วม
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</body>

</html>