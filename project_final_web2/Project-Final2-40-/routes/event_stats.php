<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

$eventId = $_GET['id'] ?? null;

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$userId = $_SESSION['user_id'];

$event = $model->getEventById($eventId);

if (!$event || $event['creator_id'] != $userId) {
    header("Location: my_activities");
    exit();
}

$statistics = $model->getEventStatistics($eventId);

View::render('event_stats', [
    'statistics' => $statistics,
    'eventTitle' => $event['Title']
]);
