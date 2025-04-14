<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class CategorySeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            'name' => 'Test Category',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->table('categories')->insert($data)->saveData();
    }
}
