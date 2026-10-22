<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != 'creator' || !isset($_GET['id'])) {
    header("Location: dashboard");
    exit();
}

$activity_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$activity = $model->getActivityByIdAndCreator($activity_id, $user_id);
if (!$activity) {
    header("Location: dashboard");
    exit();
}

$msg = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $max_people = $_POST["max_people"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    $folder_path = "uploads/event_" . $activity_id . "/";
    $upload_server_path = BASE_PATH . "/public/" . $folder_path;

    if (!is_dir($upload_server_path)) {
        mkdir($upload_server_path, 0777, true);
    }

    if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
        foreach ($_POST['delete_images'] as $del_file) {
            $clean_filename = basename($del_file);
            $file_to_delete = $upload_server_path . $clean_filename;
            if (file_exists($file_to_delete) && is_file($file_to_delete)) {
                unlink($file_to_delete);
            }

            $model->deleteEventImage($activity_id, "/" . $folder_path . $clean_filename);
            $model->deleteEventImage($activity_id, $folder_path . $clean_filename);
        }
    }

    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $count = count($_FILES['images']['name']);
        for ($i = 0; $i < $count; $i++) {
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
                $new_name = uniqid('img_') . '.' . $ext;

                if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $upload_server_path . $new_name)) {
                    $db_path = "/" . $folder_path . $new_name; 
                    $model->addEventImage($activity_id, $db_path);
                }
            }
        }
    }

    $first_image = "";
    if (is_dir($upload_server_path)) {
        $remaining_images = glob($upload_server_path . "*.{jpg,jpeg,png,gif,webp,JPG,JPEG,PNG,GIF,WEBP}", GLOB_BRACE);
        if (count($remaining_images) > 0) {
            $first_image = $folder_path . basename($remaining_images[0]);
        }
    }

    $result = $model->updateActivity($activity_id, $user_id, $title, $description, $max_people, $start_date, $end_date, $first_image, "");

    if ($result === 'cannot_reduce_below_checked_in') {
        $msg = 'ไม่สามารถลดจำนวนที่นั่งลงได้เพราะมีผู้เข้าร่วมยืนยันเข้าร่วมแล้ว (checked_in)';
        $success = false;
    } elseif ($result === 'cannot_reduce_when_full') {
        $msg = 'ไม่สามารถลดจำนวนที่นั่งได้ในตอนนี้ เนื่องจากกิจกรรมถูกเต็มแล้ว';
        $success = false;
    } elseif ($result) {
        $success = true;
    } else {
        $msg = 'อัปเดตกิจกรรมไม่สำเร็จ กรุณาลองใหม่';
        $success = false;
    }

    $activity = $model->getActivityByIdAndCreator($activity_id, $user_id);
}

View::render('edit_activity', [
    'activity' => $activity,
    'msg' => $msg,
    'success' => $success
]);
