<?php

use App\Models\Product;
use App\Models\Promotion;
use Carbon\Carbon;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Current Time: " . now()->toDateTimeString() . "\n";
echo "Current Timezone: " . config('app.timezone') . "\n";

$products = Product::whereHas('promotions')->get();

echo "Products with promotions: " . $products->count() . "\n";

foreach ($products as $product) {
    echo "Product: {$product->name} (ID: {$product->id})\n";
    echo "  Price: {$product->precio_venta}\n";

    // Check all promotions
    foreach ($product->promotions as $promo) {
        echo "  - Promo: {$promo->name} (ID: {$promo->id})\n";
        echo "    Active Flag: " . ($promo->active ? 'Yes' : 'No') . "\n";
        echo "    Start: " . ($promo->fecha_inicio ? $promo->fecha_inicio->toDateTimeString() : 'Null') . "\n";
        echo "    End: " . ($promo->fecha_fin ? $promo->fecha_fin->toDateTimeString() : 'Null') . "\n";
        echo "    Is Active via Model method? " . ($promo->isActive() ? 'Yes' : 'No') . "\n";
    }

    // Check scopeActive
    $activePromos = $product->promotions()->active()->get();
    echo "  Active Promos via Scope: " . $activePromos->count() . "\n";

    // Check attributes
    echo "  has_discount: " . ($product->has_discount ? 'Yes' : 'No') . "\n";
    echo "  discount_price: " . $product->discount_price . "\n";
    echo "---------------------------------------------------\n";
}

$allPromos = Promotion::all();
echo "\nTotal Promotions in DB: " . $allPromos->count() . "\n";
foreach ($allPromos as $p) {
    echo "Promo: {$p->name} -> Active: {$p->active}, Start: {$p->fecha_inicio}, End: {$p->fecha_fin}\n";
}
