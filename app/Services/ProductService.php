<?php

namespace App\Services;
use App\Models\Product;

class ProductService {
    public function list() {
        return Product::paginate();
    }

    public function findById(int $id) {
        $product = Product::find($id);

        if (!$product) {
            return null; 
        }

        return $product;
    }

    public function create(array $data) {
        return Product::create($data);
    }

    public function update(int $id, array $data) {
        $product = $this->findById($id);
        if (!$product) return null;
        $product->update($data);
        return $product;
    }

    public function delete(int $id) {
        $product = $this->findById($id);
        if ($product) {
            return $product->delete();
        }
        $product->delete();
    }

    public function restoreProduct($id)
    {
        $product = Product::onlyTrashed()->find($id);

        if ($product) {
            $product->restore();
            return $product;
        }

        return null;
    }
}