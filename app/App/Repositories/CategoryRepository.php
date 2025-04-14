<?php

namespace App\Repositories;

use App\DTO\CategoryDTO;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function get(int $id): CategoryDTO
    {
        $product = Category::find($id);
        if (!$product) {
            throw new \Exception("Category not found");
        }

        return new CategoryDTO($product->id, $product->name, $product->created_at);
    }
}