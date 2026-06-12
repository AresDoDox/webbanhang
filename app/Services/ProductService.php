<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
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
