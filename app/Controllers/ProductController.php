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
        $created = $productService->create($_POST, $_FILES['image']);

        if ($created) {
            Flash::set('success', 'Product created');
        } else {
            Flash::set('error', 'Failed to create product');
        }

        $this->redirect('?route=admin/products');
    }

    public function edit()
    {
        AdminMiddleware::handle();

        $productService = new ProductService();
        $product = $productService->show();

        $this->view(
            'admin/products/edit',
            compact('product')
        );
    }

    public function update()
    {
        AdminMiddleware::handle();

        if (
            !Csrf::verify($_POST['csrf'] ?? '')
        ) {
            die('Invalid CSRF');
        }

        $productService = new ProductService();
        $updated = $productService->update($_POST, $_FILES['image']);

        if ($updated) {
            Flash::set('success', 'Product updated');
        } else {
            Flash::set('error', 'Failed to update product');
        }

        $this->redirect('?route=admin/products');

        exit;
    }
}
