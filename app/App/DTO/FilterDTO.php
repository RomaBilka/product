<?php
namespace App\DTO;


use Carbon\Carbon;

readonly class FilterDTO
{
    public function __construct(
        public ?float $minPrice,
        public ?float $maxPrice,
        public ?int $categoryId,
    ) {}
}
