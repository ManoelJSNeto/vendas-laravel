<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Roupas', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Calçados', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Acessórios', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Eletrônicos', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
