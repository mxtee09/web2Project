<?php
require_once BASE_PATH . '/includes/AppModel.php';
$model = new AppModel($db);
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $model->getUserByEmail($_POST["email"]);
    if ($user && password_verify($_POST["password"], $user["Password"])) {
        $_SESSION["user_id"] = $user["UserID"];
        $_SESSION["username"] = $user["Name"];
        $_SESSION["role"] = $user["Role"];
        header("Location: dashboard");
        exit();
    } else {
        $error_msg = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
    }
}

View::render('login', ['error_msg' => $error_msg]);
