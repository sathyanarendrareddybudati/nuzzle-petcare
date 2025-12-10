<?php
namespace App\Core;

class Controller
{
    protected function render(string $view, array $data = [], string $title = 'PetCare'): void
    {
        Session::start();
        $viewFile = __DIR__ . '/../../views/' . ltrim($view, '/') . '.php';
        $layoutFile = __DIR__ . '/../../views/layouts/main.php';

        if (!is_file($viewFile)) {
            http_response_code(500);
            echo 'View not found';
            return;
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        $pageTitle = $data['pageTitle'] ?? $title;
        require $layoutFile;
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    protected function requireAuth(): void
    {
        Session::start();
        if (empty($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? '/';
            $this->redirect('/login');
        }
    }
}
