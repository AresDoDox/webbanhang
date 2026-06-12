<?php

namespace App\Services;

class UploadService
{
    public static function image(
        array $file
    ): ?string {
        if (empty($file['name'])) {
            return null;
        }

        $filename =
            time() .
            '_' .
            basename($file['name']);

        $destination =
            '../storage/uploads/' .
            $filename;

        move_uploaded_file(
            $file['tmp_name'],
            $destination
        );

        return $filename;
    }
}
