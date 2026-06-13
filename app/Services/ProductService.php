<?php

namespace App\Services;

use App\Models\Product;
use App\Helpers\Request;

class ProductService
{
    public function getAll()
    {
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

        return $products;
    }

    public function show()
    {
        $id = (int) Request::get('id');

        if (!$id) {
            die('Product ID is required');
        }

        $productModel = new Product();

        $product = $productModel->findOrFail($id);

        var_dump($product);

        return $product;
    }

    public function create(
        array $data,
        array $file
    ) {
        $image =
            UploadService::image(
                $file
            );

        $product =
            new Product();

        return $product->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $image
        ]);
    }
}
