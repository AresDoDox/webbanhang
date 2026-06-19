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
        if (!preg_match('#^https?://#i', $url)) {
            $url = BASE_PATH . rtrim($url, '/');
        }

        header("Location: $url");
        exit;
    }
}
