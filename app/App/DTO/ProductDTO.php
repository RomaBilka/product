<?php
namespace App\DTO;


use Carbon\Carbon;
use Symfony\Component\Validator\Constraints as Assert;
readonly class ProductDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'Name is required.')]
        #[Assert\Type('string', message: 'Name must be a string.')]
        #[Assert\Length(min: 3, minMessage: 'Name must be at least {{ limit }} characters long.')]
        public string $name,

        #[Assert\NotBlank(message: 'Price is required.')]
        #[Assert\Type('float', message: 'Price must be a float.')]
        #[Assert\GreaterThan(value: 0, message: 'Price must be greater than 0.')]
        public float $price,

        #[Assert\NotBlank(message: 'Category is required.')]
        public CategoryDTO $category,

        #[Assert\NotBlank(message: 'Attributes are required.')]
        #[Assert\Type('array', message: 'Attributes must be an array.')]
        public array $attributes,

        public ?string $id = null,
        public ?Carbon $created_at = null
    ) {}
}
