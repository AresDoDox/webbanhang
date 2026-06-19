<?php

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\DashboardController;
use App\Controllers\ProductController;
use App\Controllers\PostController;
use App\Controllers\AdminUserController;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register-post', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login-post', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/dashboard', [UserController::class, 'dashboard']);
$router->get('/admin/dashboard', [DashboardController::class, 'index']);
$router->get('/admin/products', [ProductController::class, 'index']);
$router->get('/admin/products/show/{id}', [ProductController::class, 'show']);
$router->get('/admin/products/create', [ProductController::class, 'create']);
$router->post('/admin/products/store', [ProductController::class, 'store']);
$router->get('/admin/products/edit/{id}', [ProductController::class, 'edit']);
$router->post('/admin/products/update', [ProductController::class, 'update']);
$router->get('/admin/products/delete/{id}', [ProductController::class, 'delete']);
$router->get('/admin/users', [AdminUserController::class, 'index']);
$router->get('/posts', [PostController::class, 'index']);
$router->get('/posts/create', [PostController::class, 'create']);
$router->post('/posts/store', [PostController::class, 'store']);
$router->get('/posts/show/{id}', [PostController::class, 'show']);
$router->get('/posts/edit/{id}', [PostController::class, 'edit']);
$router->post('/posts/update', [PostController::class, 'update']);
$router->get('/posts/delete/{id}', [PostController::class, 'delete']);

return $router;
