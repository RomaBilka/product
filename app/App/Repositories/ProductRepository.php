<?php

namespace App\Repositories;

use App\DTO\CategoryDTO;
use App\DTO\FilterDTO;
use App\DTO\ProductDTO;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function create(ProductDTO $product): ProductDTO
    {
        $productModel = Product::create([
            'name' => $product->name,
            'price' => $product->price,
            'attributes' => json_encode($product->attributes),
            'category_id' => $product->category->id,
        ]);

        return $this->productToDTO($productModel);
    }

    public function update(string $uid, ProductDTO $product): ProductDTO
    {
        $productModel = Product::findOrFail($uid);
        $productModel->update([
            'name' => $product->name,
            'price' => $product->price,
            'attributes' => json_encode($product->attributes),
            'category_id' => $product->category->id,
        ]);

        return $this->productToDTO($productModel);
    }

    public function delete(string $uid): bool
    {
        $productModel = Product::findOrFail($uid);

        return $productModel->delete();
    }

    public function get(string $uid): ProductDTO
    {
        $productModel = Product::findOrFail($uid);

        return $this->productToDTO($productModel);
    }

    /**
     * @return ProductDTO[]
     */
    public function findAll(FilterDTO $filters): array
    {
        $query = Product::with('category');

        if ($filters->minPrice !== null) {
            $query->where('price', '>=', $filters->minPrice);
        }

        if ($filters->maxPrice !== null) {
            $query->where('price', '<=', $filters->maxPrice);
        }

        if ($filters->categoryId !== null) {
            $query->where('category_id', '=', $filters->categoryId);
        }

        $products = [];

        foreach ($query->get() as $product) {
            $products[] = $this->productToDTO($product);
        }

        return $products;
    }

    protected function productToDTO(Product $product): ProductDTO
    {
        return new ProductDTO(
            $product->name,
            $product->price,
            new CategoryDTO($product->category->id, $product->category->name, $product->category->created_at),
            json_decode($product->attributes, true),
            $product->id,
            $product->created_at,
        );
    }
}