<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\DashboardController;
use App\Controllers\ProductController;
use App\Controllers\PostController;
use App\Controllers\AdminUserController;

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
        $dashboardController = new DashboardController();
        $dashboardController->index();
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

    case 'admin/products/edit':
        $productController = new ProductController();
        $productController->edit();
        break;

    case 'admin/products/update':
        $productController = new ProductController();
        $productController->update();
        break;

    case 'admin/products/delete':
        $productController = new ProductController();
        $productController->delete();
        break;

    case 'admin/users':
        $adminUserController = new AdminUserController();
        $adminUserController->index();
        break;

    case 'posts':
        $postController = new PostController();
        $postController->index();
        break;

    case 'posts/create':
        $postController = new PostController();
        $postController->create();
        break;

    case 'posts/store':
        $postController = new PostController();
        $postController->store();
        break;

    case 'posts/show':
        $postController = new PostController();
        $postController->show();
        break;

    case 'posts/edit':
        $postController = new PostController();
        $postController->edit();
        break;

    case 'posts/update':
        $postController = new PostController();
        $postController->update();
        break;

    case 'posts/delete':
        $postController = new PostController();
        $postController->delete();
        break;

    default:
        echo "404 Not Found";
}
