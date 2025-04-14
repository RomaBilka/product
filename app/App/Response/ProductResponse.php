<?php

namespace App\Response;

class ProductResponse extends Response
{

    public function __construct(private $productDTO){
    }

    public function toArray(): array
    {
        return [
            'id' => $this->productDTO->id,
            'name' => $this->productDTO->name,
            'price' => $this->productDTO->price,
            'category' => $this->productDTO->category->name,
            'attributes' => $this->productDTO->attributes,
            'created_at' => $this->productDTO->created_at,
        ];
    }
}