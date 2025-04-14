<?php

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use App\Controllers\ProductController;
use App\Services\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\DTO\ProductDTO;
use App\DTO\CategoryDTO;

class ProductControllerIntegrationTest extends TestCase
{
    public function testShowReturnsProduct()
    {
        $id = 'bb169462-b038-40fe-b0bd-c519c58bf2bd';
        $crateAt = Carbon::now();

        $productServiceMock = $this->createMock(ProductServiceInterface::class);

        $category = new CategoryDTO(1, 'Test Category');
        $product = new ProductDTO('Test Product', 99.99, $category, ['color' => 'red'], $id, $crateAt);

        $productServiceMock->method('get')->willReturn($product);

        $controller = new ProductController($productServiceMock);

        $request = new Request(['id' => $id]);

        $response = $controller->show($request);

        $this->assertInstanceOf(Response::class, $response);

        $this->assertEquals(200, $response->getStatusCode());

        $expectedContent = json_encode([
            'id' => $id,
            'name' => 'Test Product',
            'price' => 99.99,
            'category' => 'Test Category',
            'attributes' => ['color' => 'red'],
            'created_at' => $crateAt
        ]);
        $this->assertJsonStringEqualsJsonString($expectedContent, $response->getContent());
    }
}
