<?php

namespace App\Repositories;

use App\DTO\FilterDTO;
use App\DTO\ProductDTO;

interface ProductRepositoryInterface
{
    public function create(ProductDTO $product): ProductDTO;
    public function update(string $uid, ProductDTO $product): ProductDTO;
    public function delete(string $uid): bool;
    public function get(string $uid): ProductDTO;

    /**
     * @return ProductDTO[]
     */
    public function findAll(FilterDTO $filters): array;
}