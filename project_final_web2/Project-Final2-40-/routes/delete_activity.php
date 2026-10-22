<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (isset($_GET['id']) && isset($_SESSION['user_id']) && $_SESSION['role'] == 'creator') {
    $model->deleteActivity($_GET['id'], $_SESSION['user_id']);
    header("Location: my_activities?deleted=1");
    exit();
} else {
    header("Location: dashboard");
}
exit();
