<?php

namespace App\Controllers;

use App\Models\Product;
use App\Middleware\AdminMiddleware;
use App\Helpers\Csrf;
use App\Helpers\Flash;
use App\Services\ProductService;
use App\Helpers\Request;

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

    public function show()
    {
        AdminMiddleware::handle();

        $id = (int) Request::get('id');

        if (!$id) {
            die('Product ID is required');
        }

        $productModel = new Product();

        $product = $productModel->findOrFail($id);

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
