<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard");
    exit();
}

$event_id = $_GET['id'];
$user_id = $_SESSION["user_id"];

$activity = $model->getJoinedActivityDetail($event_id, $user_id);

if (!$activity) {
    header("Location: dashboard");
    exit();
}

View::render('activity_detail', [
    'activity' => $activity
]);
