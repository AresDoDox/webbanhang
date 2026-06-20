<?php

namespace App\Controllers;

use App\Middleware\AdminMiddleware;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function index()
    {
        $this->safe(function () {
            AdminMiddleware::handle();

            $stats = (new DashboardService())->getDataChart();

            $this->view(
                'admin/dashboard/index',
                compact('stats')
            );
        }, '/admin/dashboard');
    }
}
