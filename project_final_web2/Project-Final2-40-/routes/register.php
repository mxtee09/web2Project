<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);
$error_msg = "";
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    
    if (!preg_match('/@(gmail\.com|email\.com)$/i', $email)) {
        $error_msg = "กรุณาใช้อีเมล @gmail.com หรือ @email.com เท่านั้น";
    } else {
        $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $result = $model->registerUser($email, $hashed_password, $_POST["username"], $_POST["gender"], $_POST["age"], $_POST["role"], $_POST["job"]);

        if ($result) {
            header("Location: login?register=success");
            exit();
        } else {
            $error_msg = "เกิดข้อผิดพลาด หรืออีเมลนี้มีในระบบแล้ว";
        }
    }
}
View::render('register', ['error_msg' => $error_msg, 'success_msg' => $success_msg]);