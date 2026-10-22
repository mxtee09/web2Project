<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = intval($_POST['event_id']);
    $user_id = $_SESSION['user_id'];
    $force_new = isset($_POST['force_new']) && $_POST['force_new'] == '1';

    $otp = $model->getOrGenerateOTP($event_id, $user_id, $force_new);
    
    if ($otp) {
        echo json_encode(['status' => 'success', 'otp' => $otp]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถสร้าง OTP ได้']);
    }
}