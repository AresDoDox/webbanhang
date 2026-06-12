<?php

namespace App\Services;

class UploadService
{
    private static array $allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    private static int $maxSize = 2 * 1024 * 1024;

    public static function image(array $file): ?string
    {
        if (empty($file['name'])) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('Upload thất bại, mã lỗi: ' . $file['error']);
        }

        if (!in_array($file['type'], self::$allowedTypes)) {
            throw new \Exception('File không phải ảnh hợp lệ');
        }

        if ($file['size'] > self::$maxSize) {
            throw new \Exception('Ảnh vượt quá 2MB');
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid() . '.' . $extension;

        $uploadDir = dirname(__DIR__, 2) . '/storage/uploads/';

        if (!is_writable($uploadDir)) {
            throw new \Exception('Thư mục uploads không có quyền ghi. Hãy chạy lệnh: chmod -R 755 ' . $uploadDir);
        }

        $destination = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            error_log("move_uploaded_file failed. tmp: {$file['tmp_name']}, dest: $destination");
            throw new \Exception('Không thể lưu file vào thư mục đích. Kiểm tra quyền ghi của thư mục: ' . $uploadDir);
        }

        return $filename;
    }
}
