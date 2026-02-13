<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Gallifer',
            'Bayer',
            'Syngenta',
            'Purina',
            'John Deere',
            'Corteva',
            'Yara'
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand,
                'slug' => Str::slug($brand),
                'active' => true
            ]);
        }
    }
}
