<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != 'creator') {
    header("Location: dashboard");
    exit();
}

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $model->createActivity($_POST['title'], $_POST['description'], $_POST['start_date'], $_POST['end_date'], $_POST['max_people'], $_SESSION['user_id']);

    if ($event_id) {
        $folder_path = "uploads/event_" . $event_id . "/";
        $upload_server_path = BASE_PATH . "/public/" . $folder_path;

        if (!is_dir($upload_server_path)) {
            mkdir($upload_server_path, 0777, true);
        }

        $first_image = "";

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $count = count($_FILES['images']['name']);
            for ($i = 0; $i < $count; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
                    $new_name = uniqid('img_') . '.' . $ext;
                    
                    $db_image_path = "/" . $folder_path . $new_name;

                    if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $upload_server_path . $new_name)) {
                        chmod($upload_server_path . $new_name, 0644);
                        $model->addEventImage($event_id, $db_image_path);

                        if ($first_image === "") {
                            $first_image = $db_image_path;
                        }
                    }
                }
            }
        }
        
        if ($first_image !== "") {
            $model->updateActivity($event_id, $_SESSION['user_id'], $_POST['title'], $_POST['description'], $_POST['max_people'], $_POST['start_date'], $_POST['end_date'], $first_image);
        }

        $success = true;
    } else {
        $msg = "เกิดข้อผิดพลาดในการบันทึก";
    }
}

View::render('create_activity', [
    'msg' => $msg,
    'success' => isset($success) ? $success : false
]);
