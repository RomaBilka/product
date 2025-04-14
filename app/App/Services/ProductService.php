<?php

namespace App\Services;

use App\DTO\FilterDTO;
use App\DTO\ProductDTO;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Symfony\Component\Validator\Validation;

class ProductService implements ProductServiceInterface
{

    public function __construct(private ProductRepositoryInterface $productRepository, private CategoryRepositoryInterface $categoryRepository)
    {

    }

    public function create(array $data): ProductDTO
    {
        $product = $this->buildProductDTO($data);

        $validator = Validation::createValidator();
        $errors = $validator->validate($product);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException((string)$errors);
        }

        return $this->productRepository->create($product);
    }

    public function update(string $uid, array $data): ProductDTO
    {
        $product = $this->productRepository->get($uid);

        $updateProduct = $this->buildProductDTO($data, $product);

        $validator = Validation::createValidator();
        $errors = $validator->validate($updateProduct);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException((string)$errors);
        }

        return $this->productRepository->update($uid, $updateProduct);
    }

    public function delete(string $uid): bool
    {
        return $this->productRepository->delete($uid);
    }

    public function get(string $uid): ProductDTO
    {
        return $this->productRepository->get($uid);
    }

    /**
     * @return ProductDTO[]
     */
    public function findAll(array $data): array
    {
        $filter = new FilterDTO(
            $data['min_price'] ?? null,
            $data['max_price'] ?? null,
            $data['category_id'] ?? null,
        );

        return $this->productRepository->findAll($filter);
    }

    private function buildProductDTO(array $data, ?ProductDTO $existing = null): ProductDTO
    {
        $category = isset($data['category_id'])
            ? $this->categoryRepository->get($data['category_id'])
            : ($existing?->category ?? throw new \InvalidArgumentException("Category is required"));

        return new ProductDTO(
            $data['name'] ?? $existing?->name ?? '',
            $data['price'] ?? $existing?->price ?? 0.0,
            $category,
            $data['attributes'] ?? $existing?->attributes ?? [],
            $existing?->created_at ?? null,
        );
    }
}