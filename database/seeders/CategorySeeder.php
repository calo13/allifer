<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Semillas',
                'description' => 'Semillas de alta calidad para cultivos diversos'
            ],
            [
                'name' => 'Fertilizantes',
                'description' => 'Nutrición vegetal para maximizar tus cosechas'
            ],
            [
                'name' => 'Veterinaria',
                'description' => 'Medicamentos y cuidado para animales de granja'
            ],
            [
                'name' => 'Herramientas',
                'description' => 'Herramientas manuales y equipo ligero'
            ],
            [
                'name' => 'Riego',
                'description' => 'Sistemas y accesorios para riego eficiente'
            ],
            [
                'name' => 'Equipo de Protección',
                'description' => 'Seguridad personal para el trabajo agrícola'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'active' => true
            ]);
        }
    }
}
