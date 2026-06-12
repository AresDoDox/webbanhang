<?php

namespace App\Helpers;

class Validator
{
    public static function required(
        $value
    ): bool {
        return trim($value) !== '';
    }

    public static function email(
        $value
    ): bool {
        return filter_var(
            $value,
            FILTER_VALIDATE_EMAIL
        );
    }

    public static function min(
        $value,
        $length
    ): bool {
        return strlen($value) >= $length;
    }
}
