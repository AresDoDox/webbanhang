<?php

namespace App\Controllers;

use App\Helpers\Flash;

class Controller
{
    protected function view(
        string $path,
        array $data = []
    ) {
        extract($data);

        require
            "../app/Views/$path.php";
    }

    protected function redirect(
        string $url
    ): void {
        if (!preg_match('#^https?://#i', $url)) {
            $url = BASE_PATH . rtrim($url, '/');
        }

        header("Location: $url");
        exit;
    }

    protected function redirectWithError(
        string $url,
        string $message
    ): void {
        Flash::set('error', $message);
        $this->redirect($url);
    }

    protected function safe(
        callable $action,
        string $fallback = '/',
        string $defaultMessage = 'Đã có lỗi xảy ra. Vui lòng thử lại.'
    ): void {
        try {
            $action();
        } catch (\Throwable $e) {
            Flash::set('error', $e->getMessage() ?: $defaultMessage);
            $this->redirect($fallback);
        }
    }
}
