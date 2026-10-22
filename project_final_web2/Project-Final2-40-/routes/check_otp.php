<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

if ($_SESSION['role'] != 'creator') {
    header("Location: dashboard");
    exit();
}

View::render('check_otp');
