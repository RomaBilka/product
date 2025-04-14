<?php

namespace Tests\Services;

use App\DTO\CategoryDTO;
use App\DTO\ProductDTO;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function testCreateProductSuccessfully()
    {
        $data = [
            'name' => 'Test Product',
            'price' => 99.99,
            'category_id' => 1,
            'attributes' => ['color' => 'red', 'size' => 'M'],
        ];

        $category = new CategoryDTO(1, 'Clothing', Carbon::now());

        $expectedProduct = new ProductDTO(
            $data['name'],
            $data['price'],
            $category,
            $data['attributes']
        );

        $categoryRepository = $this->createMock(CategoryRepositoryInterface::class);
        $categoryRepository->method('get')
            ->with($data['category_id'])
            ->willReturn($category);

        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $productRepository->method('create')
            ->with($this->callback(function (ProductDTO $product) use ($expectedProduct) {
                return $product->name === $expectedProduct->name &&
                    $product->price === $expectedProduct->price &&
                    $product->category === $expectedProduct->category &&
                    $product->attributes === $expectedProduct->attributes;
            }))
            ->willReturn($expectedProduct);

        $service = new ProductService($productRepository, $categoryRepository);

        $result = $service->create($data);

        $this->assertInstanceOf(ProductDTO::class, $result);
        $this->assertEquals($expectedProduct->name, $result->name);
        $this->assertEquals($expectedProduct->price, $result->price);
        $this->assertEquals($expectedProduct->category, $result->category);
        $this->assertEquals($expectedProduct->attributes, $result->attributes);
    }
}
