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
                'name' => 'Sublimación',
                'description' => 'Todo tipo de productos sublimados personalizados'
            ],
            [
                'name' => 'Bordados',
                'description' => 'Bordados de alta calidad para prendas y accesorios'
            ],
            [
                'name' => 'Playeras',
                'description' => 'Playeras con diseños únicos y personalizados'
            ],
            [
                'name' => 'Tazas',
                'description' => 'Tazas mágicas, de cerámica y más'
            ],
            [
                'name' => 'Etiquetas Escolares',
                'description' => 'Etiquetas personalizadas para el regreso a clases'
            ],
            [
                'name' => 'Rollos Personalizados',
                'description' => 'Rollos con mensajes divertidos y personalizados'
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
