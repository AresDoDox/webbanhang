<?php

namespace App\Controllers;

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
        if (str_starts_with($url, '/')) {
            $url = substr($url, 7);
        }

        if (!preg_match('#^https?://#i', $url)) {
            $url = BASE_PATH . '/' . ltrim($url, '/');
        }

        header("Location: $url");
        exit;
    }
}
