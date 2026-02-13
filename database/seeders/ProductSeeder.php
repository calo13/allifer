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
        // Obtener IDs de categorías y marcas (FirstOrCreate para evitar errores si no existen)
        $semillas = Category::firstOrCreate(['slug' => 'semillas'], ['name' => 'Semillas', 'description' => 'Semillas', 'active' => true])->id;
        $fertilizantes = Category::firstOrCreate(['slug' => 'fertilizantes'], ['name' => 'Fertilizantes', 'description' => 'Fertilizantes', 'active' => true])->id;
        $veterinaria = Category::firstOrCreate(['slug' => 'veterinaria'], ['name' => 'Veterinaria', 'description' => 'Veterinaria', 'active' => true])->id;
        $herramientas = Category::firstOrCreate(['slug' => 'herramientas'], ['name' => 'Herramientas', 'description' => 'Herramientas', 'active' => true])->id;

        $gallifer = Brand::firstOrCreate(['slug' => 'gallifer'], ['name' => 'Gallifer', 'active' => true])->id;
        $bayer = Brand::firstOrCreate(['slug' => 'bayer'], ['name' => 'Bayer', 'active' => true])->id;
        $purina = Brand::firstOrCreate(['slug' => 'purina'], ['name' => 'Purina', 'active' => true])->id;
        $yara = Brand::firstOrCreate(['slug' => 'yara'], ['name' => 'Yara', 'active' => true])->id;

        $products = [
            [
                'name' => 'Semilla de Maíz Híbrido DK-7088',
                'category_id' => $semillas,
                'brand_id' => $bayer,
                'price' => 1250.00,
                'description' => 'Saco de 60,000 semillas. Alto rendimiento y tolerancia a enfermedades.',
                'stock' => 50,
            ],
            [
                'name' => 'Fertilizante Triple 15 YaraMila',
                'category_id' => $fertilizantes,
                'brand_id' => $yara,
                'price' => 385.00,
                'description' => 'Fertilizante complejo granular NPK 15-15-15. Saco de 1 quintal.',
                'stock' => 200,
            ],
            [
                'name' => 'Alimento Inicio Pollos Purina',
                'category_id' => $veterinaria,
                'brand_id' => $purina,
                'price' => 210.00,
                'description' => 'Alimento balanceado para pollos de engorde en etapa de inicio. Saco de 100 libras.',
                'stock' => 150,
            ],
            [
                'name' => 'Bomba de Mochila 20L',
                'category_id' => $herramientas,
                'brand_id' => $gallifer,
                'price' => 275.00,
                'description' => 'Fumigadora manual de mochila con capacidad de 20 litros. Lanza de acero inoxidable.',
                'stock' => 30,
            ],
            [
                'name' => 'Herbicida Glifosato 1L',
                'category_id' => $fertilizantes,
                'brand_id' => $bayer,
                'price' => 85.00,
                'description' => 'Herbicida sistémico no selectivo para el control de malezas.',
                'stock' => 100,
            ],
            [
                'name' => 'Semilla de Frijol Ligero',
                'category_id' => $semillas,
                'brand_id' => $gallifer,
                'price' => 15.00,
                'description' => 'Libra de semilla de frijol negro variedad ligero, alta producción.',
                'stock' => 500,
            ],
            [
                'name' => 'Vitaminas Avícolas Solubles',
                'category_id' => $veterinaria,
                'brand_id' => $purina,
                'price' => 45.00,
                'description' => 'Suplemento vitamínico en polvo para aves de corral. Sobre de 100g.',
                'stock' => 300,
            ]
        ];

        foreach ($products as $product) {
            $slug = Str::slug($product['name']);
            $imagePath = null;

            // Check if image exists in storage/app/public/products/
            // Supongamos que las imágenes se guardan como {slug}.jpg o .png
            if (file_exists(storage_path('app/public/products/' . $slug . '.jpg'))) {
                $imagePath = 'products/' . $slug . '.jpg';
            } elseif (file_exists(storage_path('app/public/products/' . $slug . '.png'))) {
                $imagePath = 'products/' . $slug . '.png';
            } elseif (file_exists(storage_path('app/public/products/' . $slug . '.jpeg'))) {
                $imagePath = 'products/' . $slug . '.jpeg';
            }

            Product::create([
                'name' => $product['name'],
                'slug' => $slug,
                'description' => $product['description'],
                'precio_venta' => $product['price'],
                'precio_costo' => $product['price'] * 0.7, // Margen aprox 30%
                'stock' => $product['stock'],
                'category_id' => $product['category_id'],
                'brand_id' => $product['brand_id'],
                'image' => $imagePath, // Assign detected image
                'active' => true,
                'featured' => rand(0, 1) == 1
            ]);
        }
    }
}
