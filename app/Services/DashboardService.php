<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use App\Models\Post;

class DashboardService
{
    public function getStats(): array
    {
        return [
            'users' => (new User())->count(),

            'admins' => (new User())->countAdmins(),

            'products' => (new Product())->count(),

            'posts' => (new Post())->count()
        ];
    }
}
