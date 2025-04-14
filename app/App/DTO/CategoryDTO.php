<?php
namespace App\DTO;


use Carbon\Carbon;

readonly class CategoryDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?Carbon $created_at = null,
    ) {}
}
