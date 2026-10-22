<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$event_id = $_GET['id'] ?? null;

if (!$event_id) {
    header("Location: dashboard");
    exit();
}

$activity = $model->getEventById($event_id);

if (!$activity) {
    header("Location: dashboard");
    exit();
}
$creator_name = "ไม่ระบุ";
if (isset($activity['creator_id'])) {
    $creator_name = $model->getUserNameById($activity['creator_id']);
}
View::render('view_activity', [
    'activity' => $activity,
    'creator_name' => $creator_name
]);
