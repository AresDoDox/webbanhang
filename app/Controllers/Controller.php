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
        header("Location: $url");
        exit;
    }
}
