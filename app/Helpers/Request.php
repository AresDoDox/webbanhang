<?php

namespace App\Helpers;

class Request
{
    public static function get(
        string $key,
        mixed $default = null
    ) {
        return $_GET[$key] ?? $default;
    }

    public static function post(
        string $key,
        mixed $default = null
    ) {
        return $_POST[$key] ?? $default;
    }
}
