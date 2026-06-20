<?php

namespace App\Helpers;

class Request
{
    /**
     * Phương thức HTTP hiện tại
     * @var string|null
     */
    private static $method = null;

    /**
     * Dữ liệu request đã parse (cache)
     * @var array|null
     */
    private static $requestData = null;

    /**
     * Lấy tham số từ $_GET hoặc toàn bộ $_GET nếu không truyền key
     *
     * @param string|null $key     Tên tham số cần lấy (bỏ qua để lấy toàn bộ)
     * @param mixed       $default Giá trị mặc định nếu không tồn tại
     * @return mixed
     */
    public static function get(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }

    /**
     * Lấy tham số từ $_POST hoặc toàn bộ $_POST nếu không truyền key
     *
     * @param string|null $key     Tên tham số cần lấy (bỏ qua để lấy toàn bộ)
     * @param mixed       $default Giá trị mặc định nếu không tồn tại
     * @return mixed
     */
    public static function post(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }

    /**
     * Lấy tất cả dữ liệu request (hợp nhất từ $_GET, $_POST và dữ liệu raw)
     *
     * @return array
     */
    public static function all(): array
    {
        if (self::$requestData === null) {
            self::$requestData = self::parseRequestData();
        }
        return self::$requestData;
    }

    /**
     * Phân tích và hợp nhất toàn bộ dữ liệu đầu vào
     *
     * @return array
     */
    private static function parseRequestData(): array
    {
        $data = $_GET;

        // Gộp $_POST nếu có
        if (!empty($_POST)) {
            $data = array_merge($data, $_POST);
        }

        // Xử lý dữ liệu raw từ php://input (nếu có)
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        // Không đọc nếu là multipart/form-data (vì php://input rỗng)
        if (strpos($contentType, 'multipart/form-data') === false) {
            $raw = file_get_contents('php://input');
            if (!empty($raw)) {
                if (strpos($contentType, 'application/json') !== false) {
                    $json = json_decode($raw, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
                        $data = array_merge($data, $json);
                    }
                } elseif (strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
                    parse_str($raw, $parsed);
                    if (is_array($parsed)) {
                        $data = array_merge($data, $parsed);
                    }
                }
                // Có thể mở rộng thêm các định dạng khác nếu cần
            }
        }

        return $data;
    }

    /**
     * Lấy phương thức HTTP của request hiện tại
     *
     * @return string (GET, POST, PUT, DELETE, PATCH, …)
     */
    public static function method(): string
    {
        if (self::$method === null) {
            self::$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        }
        return self::$method;
    }

    /**
     * Kiểm tra request hiện tại có phải là POST không
     *
     * @return bool
     */
    public static function isPost(): bool
    {
        return self::method() === 'POST';
    }
}
