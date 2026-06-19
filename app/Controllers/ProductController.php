<?php

namespace App\Controllers;

use App\Middleware\AdminMiddleware;
use App\Helpers\Csrf;
use App\Helpers\Flash;
use App\Services\ProductService;
use App\Validators\ProductValidator;
use App\Helpers\Request;

class ProductController extends Controller
{
    public function index()
    {
        AdminMiddleware::handle();

        $productService = new ProductService();
        $result = $productService->getAll();

        $this->view(
            'admin/products/index',
            compact('result')
        );
    }

    public function show()
    {
        AdminMiddleware::handle();

        $id = (int) Request::get('id');

        if (!$id) {
            throw new \Exception('Product ID is required');
        }

        $productService = new ProductService();
        $product = $productService->show($id);

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

        if (!Csrf::verify($_POST['csrf'] ?? '')) {
            throw new \Exception('Invalid CSRF');
        }

        $errors = ProductValidator::validate($_POST);

        if (!empty($errors)) {
            Flash::set('error', $errors[0]);
            return $this->redirect('/admin/products/create');
        }

        $productService = new ProductService();
        $productService->create($_POST, $_FILES['image']);

        // if ($created) {
        //     Flash::set('success', 'Product created');
        // } else {
        //     Flash::set('error', 'Failed to create product');
        // }

        $this->redirect('/admin/products');
    }

    public function edit()
    {
        AdminMiddleware::handle();

        $id = (int) Request::get('id');

        if (!$id) {
            throw new \Exception('Product ID is required');
        }

        $productService = new ProductService();
        $product = $productService->show($id);

        $this->view(
            'admin/products/edit',
            compact('product')
        );
    }

    public function update()
    {
        AdminMiddleware::handle();

        $id = (int) Request::post('id');

        if (!$id) {
            throw new \Exception('Product ID is required');
        }

        if (
            !Csrf::verify($_POST['csrf'] ?? '')
        ) {
            throw new \Exception('Invalid CSRF');
        }

        $errors = ProductValidator::validate($_POST);

        if (!empty($errors)) {
            Flash::set('error', $errors[0]);
            return $this->redirect('/admin/products/create');
        }

        $productService = new ProductService();
        $updated = $productService->update($id, $_POST, $_FILES['image']);

        if ($updated) {
            Flash::set('success', 'Product updated');
        } else {
            Flash::set('error', 'Failed to update product');
        }

        $this->redirect('/admin/products');

        exit;
    }

    public function delete()
    {
        AdminMiddleware::handle();

        $id = (int) Request::get('id');

        if (!$id) {
            throw new \Exception('Product ID is required');
        }

        $productService = new ProductService();
        $deleted = $productService->delete($id);

        if ($deleted) {
            Flash::set('success', 'Product deleted');
        } else {
            Flash::set('error', 'Failed to delete product');
        }

        $this->redirect('/admin/products');

        exit;
    }
}
