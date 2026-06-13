<?php

namespace App\Controllers;

use App\Middleware\AdminMiddleware;
use App\Helpers\Csrf;
use App\Helpers\Flash;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function index()
    {
        AdminMiddleware::handle();

        $productService = new ProductService();
        $products = $productService->getAll();

        $this->view(
            'admin/products/index',
            compact('products')
        );
    }

    public function show()
    {
        AdminMiddleware::handle();

        $productService = new ProductService();
        $product = $productService->show();

        $this->view(
            'admin/products/show',
            compact('product')
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
            !Csrf::verify($_POST['csrf'] ?? '')
        ) {
            die('Invalid CSRF');
        }

        $productService = new ProductService();
        $productService->create($_POST, $_FILES['image']);

        Flash::set(
            'success',
            'Product created'
        );

        $this->redirect('?route=admin/products');
    }
}
