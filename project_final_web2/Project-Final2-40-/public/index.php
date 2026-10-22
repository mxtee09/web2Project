<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/includes/database.php';
require_once BASE_PATH . '/includes/view.php';
require_once BASE_PATH . '/includes/router.php';

$dbInstance = new Database();
$db = $dbInstance->getConnection();

header('Content-Type: text/html; charset=UTF-8');

$router = new Router($db);
$router->run();
