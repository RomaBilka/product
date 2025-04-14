<?php

namespace App\Response;

class ProductsResponse extends Response
{

    public function __construct(readonly array $productsDTO){
    }

    public function toArray(): array
    {
        $products = [];

        foreach ($this->productsDTO as $product) {
            $products[] = (new ProductResponse($product))->toArray();
        }

        return $products;
    }
}