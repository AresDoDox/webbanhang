<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Csrf;
use App\Helpers\Validator;
use App\Helpers\Flash;
use App\Middleware\GuestMiddleware;

class AuthController extends Controller
{
    public function showRegister()
    {
        GuestMiddleware::handle();

        $this->view('auth/register');
    }

    public function register()
    {
        $user = new User();

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!Csrf::verify($_POST['csrf'] ?? '')) {
            throw new \Exception('Invalid CSRF token');
        }

        if (!Validator::required($name)) {

            Flash::set(
                'error',
                'Tên không được để trống'
            );

            $this->redirect('?route=register');
            exit;
        }

        if (!Validator::email($email)) {

            Flash::set(
                'error',
                'Email không hợp lệ'
            );

            $this->redirect('?route=register');
            exit;
        }

        if (!Validator::min($password, 6)) {

            Flash::set(
                'error',
                'Mật khẩu tối thiểu 6 ký tự'
            );

            $this->redirect('?route=register');
            exit;
        }

        if ($user->emailExists($email)) {
            Flash::set(
                'error',
                'Email đã tồn tại'
            );

            $this->redirect('?route=register');
            exit;
        }

        if ($user->create($_POST)) {
            Flash::set(
                'success',
                'Đăng ký thành công. Vui lòng đăng nhập.'
            );

            $this->redirect('?route=login');
        } else {
            echo "Đăng ký thất bại!";
        }
    }

    public function showLogin()
    {
        GuestMiddleware::handle();
        $this->view('auth/login');
    }

    public function login()
    {
        $user = new User();
        $foundUser = $user->findByEmail($_POST['email']);

        if ($foundUser && password_verify($_POST['password'], $foundUser['password'])) {

            $_SESSION['user'] = $foundUser;
            if (
                $foundUser['role'] === 'admin'
            ) {
                $this->redirect('?route=admin/dashboard');
            } else {
                $this->redirect('?route=dashboard');
            }
        } else {
            Flash::set(
                'error',
                'Email hoặc mật khẩu không đúng'
            );

            $this->redirect('?route=login');
        }
    }

    public function logout()
    {
        session_destroy();

        $this->redirect('?route=login');
    }
}