<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}

$search = $_GET['search'] ?? "";
$creator = $_GET['creator'] ?? "";
$dateFrom = $_GET['date_from'] ?? "";
$dateTo = $_GET['date_to'] ?? "";

$activities = $model->getAllActivities($search, $creator, $dateFrom, $dateTo);

View::render('all_activities', [
    'activities' => $activities,
    'search' => $search,
    'creator' => $creator,
    'date_from' => $dateFrom,
    'date_to' => $dateTo,
    'model' => $model
]);
