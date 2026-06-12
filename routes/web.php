<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\ProductController;

$route = $_GET['route'] ?? '/';
switch ($route) {
    case '/':
        $homeController = new HomeController();
        $homeController->index();
        break;

    case 'register':
        $authController = new AuthController();
        $authController->showRegister();
        break;

    case 'register-post':
        $authController = new AuthController();
        $authController->register();
        break;

    case 'login':
        $authController = new AuthController();
        $authController->showLogin();
        break;

    case 'login-post':
        $authController = new AuthController();
        $authController->login();
        break;

    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;

    case 'dashboard':
        $userController = new UserController();
        $userController->dashboard();
        break;

    case 'admin/dashboard':
        $adminController = new AdminController();
        $adminController->dashboard();
        break;

    case 'admin/products':
        $productController = new ProductController();
        $productController->index();
        break;

    case 'admin/products/show':
        $productController = new ProductController();
        $productController->show();
        break;

    case 'admin/products/create':
        $productController = new ProductController();
        $productController->create();
        break;

    case 'admin/products/store':
        $productController = new ProductController();
        $productController->store();
        break;

    default:
        echo "404 Not Found";
}
