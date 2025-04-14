<?php

namespace App\Controllers;

use App\Response\{ProductResponse, ProductsResponse};
use App\Services\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController
{
    public function __construct(private ProductServiceInterface $productService)
    {
    }

    public function create(Request $request)
    {
        try {
            $product = $this->productService->create($request->all());
        } catch (\InvalidArgumentException $e) {
            return new Response("Invalid argument: " . $e->getMessage(), 400);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 400);
        } catch (\Throwable $e) {
            return new Response($e->getMessage(), 500);
        }

        return new Response((new ProductResponse($product))->toJson(), 201);
    }


    public function show(Request $request)
    {
        try {
            $product = $this->productService->get($request->input('id'));
        } catch (\Exception $e) {
            return new Response("Not found", 404);
        } catch (\Throwable $e) {
            return new Response($e->getMessage(), 500);
        }

        return new Response((new ProductResponse($product))->toJson(), 200);
    }

    public function update(Request $request)
    {
        try {
            $product = $this->productService->update($request->input('id'), $request->all());
        } catch (\InvalidArgumentException $e) {
            return new Response("Invalid argument: " . $e->getMessage(), 400);
        } catch (\Exception $e) {
            return new Response("Not found", 404);
        } catch (\Throwable $e) {
            return new Response($e->getMessage(), 500);
        }

        return new Response((new ProductResponse($product))->toJson(), 200);
    }

    public function delete(Request $request)
    {
        try {
            $this->productService->delete($request->input('id'));
        } catch (\Exception $e) {
            return new Response("Not found", 404);
        } catch (\Throwable $e) {
            return new Response($e->getMessage(), 500);
        }

        return new Response('No Content', 204);
    }

    public function list(Request $request)
    {
        try {
            $products = $this->productService->findAll($request->all());
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 400);
        } catch (\Throwable $e) {
            return new Response($e->getMessage(), 500);
        }

        if (empty($products)) {
            return new Response('Not found', 404);
        }

        return new Response((new ProductsResponse($products))->toJson(), 200);
    }
}