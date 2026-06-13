<?php

namespace App\Validators;

class ProductValidator
{
    public static function validate(array $data): array
    {
        $errors = [];

        if (empty(trim($data['name']))) {
            $errors[] = 'Tên sản phẩm bắt buộc';
        }

        if (!is_numeric($data['price'])) {
            $errors[] = 'Giá không hợp lệ';
        }

        return $errors;
    }
}
