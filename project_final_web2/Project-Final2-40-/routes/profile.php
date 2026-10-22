<?php
require_once BASE_PATH . '/includes/AppModel.php';
if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}

$user_id = intval($_SESSION["user_id"]);
$model = new AppModel($db);

$query = "SELECT * FROM user WHERE UserID = $user_id";
$result = $db->query($query);
$user_info = $result->fetch_assoc();

if (!$user_info) {
    header("Location: dashboard");
    exit();
}

$joined_result = $model->getJoinedActivities($user_id);
$history = [];
if ($joined_result) {
    while ($row = $joined_result->fetch_assoc()) {
        $history[] = $row;
    }
}

View::render('profile', [
    'user_info' => $user_info,
    'history' => $history 
]);