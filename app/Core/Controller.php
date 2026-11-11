<?php

class Controller
{
    protected function view(string $view, array $data = [])
    {
        $viewPath = __DIR__ . "/../../resources/views/" . $view . ".php";


        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo "View not found: " . $view;
            return;
        }

        extract($data);

        require $viewPath;
    }
    protected function redirect(string $url)
    {
        if (isset($_SERVER['SCRIPT_NAME'])) {
            // dirname('/.../public/index.php') => http /.../php-mvc/
            $baseDir = preg_replace('#public$#i', '', str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])));
            if ($baseDir != '' && $baseDir !== '/' && !str_starts_with($url, 'http')) {
                $url = rtrim($baseDir, '/') . '/' . ltrim($url, '/');
            }
        }

        header("Location: $url");
    }
    protected function requireLogin()
    {
        if (empty($_SESSION['admin_id'])) {
            $_SESSION['error'] = 'pls login!';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
}

?>