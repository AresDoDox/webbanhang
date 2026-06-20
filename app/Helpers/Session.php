<?php

namespace App\Helpers;

class Session
{
    /**
     * Trạng thái session đã được khởi tạo chưa
     */
    private static $started = false;

    /**
     * Khởi động session nếu chưa được kích hoạt
     *
     * @return void
     */
    private static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            self::$started = true;
        } elseif (session_status() === PHP_SESSION_ACTIVE) {
            self::$started = true;
        }
    }

    /**
     * Lấy giá trị của một key trong session
     *
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Gán giá trị cho một key trong session
     *
     * @param string $key
     * @param mixed  $value
     * @return void
     */
    public static function set(string $key, $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Alias của set()
     */
    public static function put(string $key, $value): void
    {
        self::set($key, $value);
    }

    /**
     * Kiểm tra key tồn tại trong session
     *
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Xóa một key khỏi session
     *
     * @param string $key
     * @return void
     */
    public static function delete(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Lấy toàn bộ dữ liệu session
     *
     * @return array
     */
    public static function all(): array
    {
        self::start();
        return $_SESSION;
    }

    /**
     * Xóa toàn bộ session và hủy phiên
     *
     * @return void
     */
    public static function destroy(): void
    {
        self::start();
        $_SESSION = [];
        session_destroy();
        self::$started = false;
    }

    /**
     * Tạo lại session ID (tăng tính bảo mật)
     *
     * @param bool $deleteOldSession Xóa session cũ không? Mặc định true
     * @return void
     */
    public static function regenerate(bool $deleteOldSession = true): void
    {
        self::start();
        session_regenerate_id($deleteOldSession);
    }

    /**
     * Lưu giá trị flash (chỉ tồn tại cho lần request tiếp theo)
     *
     * @param string $key
     * @param mixed  $value
     * @return void
     */
    public static function flash(string $key, $value): void
    {
        self::start();
        $_SESSION['_flash'][$key] = $value;
    }

    /**
     * Lấy giá trị flash và xóa nó ngay sau khi lấy
     *
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public static function getFlash(string $key, $default = null)
    {
        self::start();
        $value = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);
        return $value;
    }

    /**
     * Alias của getFlash (pull)
     */
    public static function pull(string $key, $default = null)
    {
        return self::getFlash($key, $default);
    }

    /**
     * Lấy toàn bộ flash và xóa sạch chúng
     *
     * @return array
     */
    public static function getAllFlash(): array
    {
        self::start();
        $flashes = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);
        return $flashes;
    }

    /**
     * Kiểm tra xem có flash nào đang chờ không
     *
     * @param string|null $key
     * @return bool
     */
    public static function hasFlash(?string $key = null): bool
    {
        self::start();
        if ($key === null) {
            return isset($_SESSION['_flash']) && count($_SESSION['_flash']) > 0;
        }
        return isset($_SESSION['_flash'][$key]);
    }

    /**
     * Xóa toàn bộ flash mà không lấy
     */
    public static function clearFlash(): void
    {
        self::start();
        unset($_SESSION['_flash']);
    }
}
