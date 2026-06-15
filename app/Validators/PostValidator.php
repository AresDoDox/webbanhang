<?php

namespace App\Validators;

class PostValidator
{
    public static function validate(array $data): array
    {
        $errors = [];

        if (empty(trim($data['title']))) {
            $errors[] = 'Tiêu đề bài viết bắt buộc';
        }

        return $errors;
    }
}
