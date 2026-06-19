<?php

namespace App\Controllers;

use App\Middleware\AdminMiddleware;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function index()
    {
        AdminMiddleware::handle();

        $stats = (new DashboardService())->getStats();

        $this->view(
            'admin/dashboard/index',
            compact('stats')
        );
    }
}
