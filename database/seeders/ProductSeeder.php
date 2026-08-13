<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roupas = Category::where('name', 'Roupas')->first()->id;
        $calcados = Category::where('name', 'Calçados')->first()->id;
        $acessorios = Category::where('name', 'Acessórios')->first()->id;
        $eletronicos = Category::where('name', 'Eletrônicos')->first()->id;

        Product::insert([
            [
                'category_id' => $roupas,
                'name' => 'Camiseta Estampada',
                'description' => 'Camiseta 100% algodão com estampa divertida. Disponível em várias cores.',
                'price' => 29.90,
                'stock' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $calcados,
                'name' => 'Tênis Esportivo',
                'description' => 'Tênis esportivo com tecnologia de amortecimento. Ideal para corrida e atividades físicas.',
                'price' => 199.90,
                'stock' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $eletronicos,
                'name' => 'Relógio Digital',
                'description' => 'Relógio digital com cronômetro e alarme. Design moderno e resistente à água.',
                'price' => 89.90,
                'stock' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $acessorios,
                'name' => 'Mochila Casual',
                'description' => 'Mochila casual com vários compartimentos. Ideal para o dia a dia e viagens curtas.',
                'price' => 149.90,
                'stock' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $eletronicos,
                'name' => 'Fone de Ouvido Bluetooth',
                'description' => 'Fone de ouvido Bluetooth com cancelamento de ruído e bateria de longa duração.',
                'price' => 129.90,
                'stock' => 35,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $acessorios,
                'name' => 'Óculos de Sol',
                'description' => 'Óculos de sol com proteção UV e design estiloso. Disponível em várias cores de lente.',
                'price' => 79.90,
                'stock' => 45,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $roupas,
                'name' => 'Jaqueta de Couro',
                'description' => 'Jaqueta de couro legítimo, ideal para o inverno. Disponível em tamanhos diversos.',
                'price' => 299.90,
                'stock' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $acessorios,
                'name' => 'Capacete de Bicicleta',
                'description' => 'Capacete de bicicleta com sistema de ventilação e ajuste para maior conforto e segurança.',
                'price' => 119.90,
                'stock' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
