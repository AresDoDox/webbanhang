<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Middleware\AdminMiddleware;
use App\Helpers\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $this->safe(function () {
            AdminMiddleware::handle();

            $keyword = trim(Request::get('keyword', ''));
            $page = (int) Request::get('page', 1);
            $limit   = 10;

            $userService = new UserService();
            $result = $userService->getUsers($page, $limit, $keyword);

            $this->view(
                'admin/users/index',
                compact('result')
            );
        }, 'admin/users');
    }
}
