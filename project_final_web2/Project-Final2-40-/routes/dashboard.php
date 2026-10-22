<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}

$user_id = $_SESSION["user_id"];

$joinedActivities = $model->getJoinedActivities($user_id);

$myActivities = null;
if ($_SESSION['role'] == 'creator') {
    $myActivities = $model->getActivitiesByCreator($user_id);
}

View::render('dashboard', [
    'myActivities' => $myActivities,
    'joinedActivities' => $joinedActivities,
    'model' => $model
]);
