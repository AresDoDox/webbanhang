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
}
