<?php
class Router
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        $path = str_replace($scriptName, '', $uri);
        $path = trim($path, '/');

        if (empty($path) || $path === 'index.php') {
            $routeFile = 'dashboard';
        } else {
            $routeFile = basename($path);
        }

        $targetFile = BASE_PATH . '/routes/' . $routeFile . '.php';

        if (file_exists($targetFile)) {
            $db = $this->db;
            require_once $targetFile;
        } else {
            View::render('404');
        }
    }
}
