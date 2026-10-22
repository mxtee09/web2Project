<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$event_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];

$from = $_GET['from'] ?? 'all_activities';

if ($event_id) {
    if ($model->leaveActivity($event_id, $user_id)) {
        header("Location: $from?status=success&msg=leave_done");
        exit();
    }
}

header("Location: $from?status=error&msg=leave_fail");
exit();
