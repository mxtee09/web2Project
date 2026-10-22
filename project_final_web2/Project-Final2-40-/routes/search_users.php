<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

$search = $_GET['search'] ?? "";
$current_user_id = $_SESSION['user_id'] ?? null;

// เรียกใช้ฟังก์ชันที่สร้างใหม่ โดยส่ง ID ตัวเองไปเพื่อไม่ให้แสดงผล (ข้อ 1.3.1)
$users = $model->searchUsersWithEventCount($search, $current_user_id);

View::render('search_users', [
    'users' => $users,
    'search' => $search
]);