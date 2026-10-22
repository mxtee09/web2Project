<?php
class View
{
    public static function render($templateName, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

        $templatePath = BASE_PATH . '/templates/' . $templateName . '.php';

        if (file_exists($templatePath)) {
            require $templatePath;
        } else {
            die("Error: ไม่พบไฟล์ Template -> {$templateName}.php");
        }
    }
}
