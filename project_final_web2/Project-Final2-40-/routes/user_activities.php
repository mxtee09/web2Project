<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

$creator_id = $_GET['id'] ?? null;

if (!$creator_id) {
    header("Location: search_users");
    exit();
}

$creator_info = $model->getUserInfoById($creator_id);
if (!$creator_info) {
    header("Location: search_users");
    exit();
}

// ดึงกิจกรรมที่สร้างโดยผู้ใช้นี้
$activities = $model->getActivitiesByCreator($creator_id);

View::render('user_activities', [
    'creator_info' => $creator_info,
    'activities' => $activities,
    'model' => $model
]);