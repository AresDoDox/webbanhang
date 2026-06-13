<?php

namespace App\Services;

use App\Models\Product;
use App\Helpers\Request;

class ProductService
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function getAll()
    {
        $keyword =
            $_GET['keyword'] ?? '';

        if ($keyword) {
            $products =
                $this->productModel->search(
                    $keyword
                );
        } else {
            $products = $this->productModel->getAll();
        }

        return $products;
    }

    public function show()
    {
        $id = (int) Request::get('id');

        if (!$id) {
            die('Product ID is required');
        }

        $product = $this->productModel->findOrFail($id);

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

        return $this->productModel->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $image
        ]);
    }

    public function update(
        array $data,
        array $file
    ) {
        $id = (int) Request::post('id');

        if (!$id) {
            die('Product ID is required');
        }

        $product = $this->productModel->findOrFail($id);

        $image = $product['image'];

        if (!empty($file['name'])) {
            $image =
                UploadService::image(
                    $file
                );
        }

        $updateData = [
            'name'        => $data['name'] ?? '',
            'description' => $data['description'] ?? '',
            'price'       => $data['price'] ?? 0,
            'image'       => $image,
        ];

        return $this->productModel->update($id, $updateData);
    }
}
