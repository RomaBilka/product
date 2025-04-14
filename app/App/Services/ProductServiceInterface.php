<?php

namespace App\Services;

use App\DTO\ProductDTO;

interface ProductServiceInterface
{
    public function create(array $data): ProductDTO;
    public function update(string $uid, array $data): ProductDTO;
    public function delete(string $uid): bool;
    public function get(string $uid): ProductDTO;

    /**
     * @return ProductDTO[]
     */
    public function findAll(array $data): array;
}