<?php

namespace App\Controllers;

use App\Models\Product;
use App\Middleware\AdminMiddleware;
use App\Services\UploadService;
use App\Helpers\Csrf;
use App\Helpers\Flash;

class ProductController extends Controller
{
    public function index()
    {
        AdminMiddleware::handle();

        $product = new Product();

        $keyword =
            $_GET['keyword'] ?? '';

        if ($keyword) {
            $products =
                $product->search(
                    $keyword
                );
        } else {
            $products = $product->getAll();
        }

        $this->view(
            'admin/products/index',
            compact('products')
        );
    }

    public function create()
    {
        AdminMiddleware::handle();

        $this->view(
            'admin/products/create'
        );
    }

    public function store()
    {
        AdminMiddleware::handle();

        if (
            !Csrf::verify(
                $_POST['csrf'] ?? ''
            )
        ) {
            die('Invalid CSRF');
        }

        $image =
            UploadService::image(
                $_FILES['image']
            );

        $product = new Product();

        $product->create([
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'image' => $image
        ]);

        Flash::set(
            'success',
            'Product created'
        );

        header(
            'Location:?route=admin/products'
        );
    }
}
