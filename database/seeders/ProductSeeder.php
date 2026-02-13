<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de categorías y marcas
        $sublimacion = Category::where('slug', 'sublimacion')->first()->id;
        $playeras = Category::where('slug', 'playeras')->first()->id;
        $tazas = Category::where('slug', 'tazas')->first()->id;
        $etiquetas = Category::where('slug', 'etiquetas-escolares')->first()->id;
        $rollos = Category::where('slug', 'rollos-personalizados')->first()->id;

        $carinitos = Brand::where('name', 'Cariñitos GT')->first()?->id ?? Brand::first()->id;

        $products = [
            [
                'name' => 'Playera Navideña Personalizada',
                'category_id' => $playeras,
                'price' => 75.00,
                'description' => 'Playera de algodón con diseño navideño personalizado. Disponible en todas las tallas.',
                'stock' => 50,
            ],
            [
                'name' => 'Taza Mágica con Foto',
                'category_id' => $tazas,
                'price' => 45.00,
                'description' => 'Taza que revela la imagen al verter líquido caliente. Ideal para regalos sorpresa.',
                'stock' => 100,
            ],
            [
                'name' => 'Pack Etiquetas Escolares Paw Patrol',
                'category_id' => $etiquetas,
                'price' => 35.00,
                'description' => '20 etiquetas para libros y cuadernos (7x4.5cm) + 8 etiquetas personaje. Diseño Paw Patrol.',
                'stock' => 200,
            ],
            [
                'name' => 'Pack Etiquetas Escolares Spidey',
                'category_id' => $etiquetas,
                'price' => 35.00,
                'description' => '20 etiquetas para libros y cuadernos + 8 etiquetas personaje. Diseño Spidey.',
                'stock' => 200,
            ],
            [
                'name' => 'Rollo de Papel "El Grinch"',
                'category_id' => $rollos,
                'price' => 10.00,
                'description' => 'Rollo de papel higiénico con diseño divertido del Grinch. Ideal para bromas navideñas.',
                'stock' => 500,
            ],
            [
                'name' => 'Rollo de Papel "Santa Claus"',
                'category_id' => $rollos,
                'price' => 10.00,
                'description' => 'Rollo de papel higiénico con diseño de Santa. Un detalle gracioso para el baño de visitas.',
                'stock' => 500,
            ]
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'precio_venta' => $product['price'],
                'precio_costo' => $product['price'] * 0.6, // Costo estimado
                'stock' => $product['stock'],
                'category_id' => $product['category_id'],
                'brand_id' => $carinitos,
                'active' => true,
                'featured' => true
            ]);
        }
    }
}
