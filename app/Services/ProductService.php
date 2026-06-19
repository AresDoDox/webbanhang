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
        $keyword = Request::get('keyword', '');
        $page = (int) Request::get('page', 1);
        $limit   = 10;

        if ($keyword) {
            $result = $this->productModel->searchPaginate($keyword, $page, $limit);
        } else {
            $result = $this->productModel->paginate($page, $limit);
        }

        return $result;
    }

    public function show(int $id)
    {
        $product = $this->productModel->findOrFail($id);

        return $product;
    }

    public function create(
        array $data,
        array $file
    ) {
        $image = UploadService::image($file);

        $this->productModel->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $image
        ]);

        return;
    }

    public function update(
        int $id,
        array $data,
        array $file
    ) {
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

    public function delete(int $id)
    {
        return $this->productModel->delete($id);
    }
}
