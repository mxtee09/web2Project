<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

if ($_SESSION['role'] != 'creator') {
    header("Location: dashboard");
    exit();
}

$user_id = $_SESSION['user_id'];

$myActivities = $model->getActivitiesByCreator($user_id);

View::render('my_activities', [
    'myActivities' => $myActivities,
    'model' => $model
]);
