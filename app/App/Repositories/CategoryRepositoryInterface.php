<?php

namespace App\Repositories;

use App\DTO\CategoryDTO;

interface CategoryRepositoryInterface
{

    public function get(int $id): CategoryDTO;

}