<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'creator') {
    header("Location: dashboard");
    exit();
}

$event_id = $_GET['event_id'];
$user_id = $_GET['user_id'];
$action = $_GET['action'];

$res = $model->manageParticipantStatus($event_id, $user_id, $action);

if ($res == 'full') {
    echo "<script>alert('ไม่สามารถอนุมัติได้ จำนวนคนเต็มแล้ว!'); window.history.back();</script>";
    exit();
}

header("Location: my_activities");
exit();
