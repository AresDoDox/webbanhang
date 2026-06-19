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

    public function getDataChart(): array
    {
        return [
            'users' => [
                'total' => (new User())->count(),
                'monthly' => (new User())->monthlyRegistrations()
            ],

            'products' => [
                'total' => (new Product())->count(),
                'monthly' => (new Product())->monthlyProducts()
            ],

            'posts' => [
                'total' => (new Post())->count(),
                'monthly' => (new Post())->monthlyPosts()
            ]
        ];
    }
}
