<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (!isset($_SESSION['user_id'])) {
    exit('Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = intval($_POST['event_id']);
    $user_id = $_SESSION['user_id'];
    $input_otp = $_POST['otp'] ?? '';

    if ($model->verifyUserOTP($event_id, $user_id, $input_otp)) {
        if ($model->markAsCheckedIn($event_id, $user_id)) {
            echo "Success";
        } else {
            echo "Error";
        }
    } else {
        echo "Invalid_OTP";
    }
}