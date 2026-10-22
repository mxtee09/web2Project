<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);


if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$user_id = intval($_SESSION['user_id']);
$event_id = intval($_GET['id']);


$result = $model->joinActivity($event_id, $user_id);

if ($result === "success") {
    header("Location: all_activities?join_success=1");
    exit();
} else {

    header("Location: all_activities?join_error=" . $result);
    exit();
}
