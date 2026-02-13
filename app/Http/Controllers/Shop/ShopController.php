<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
 public function index(Request $request)
{
    $search = $request->get('search');
    $category_id = $request->get('category');

    $products = Product::with(['category', 'images', 'variants'])
        ->where('active', true)
        ->where('stock', '>', 0)
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })
        ->when($category_id, function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    $categories = Category::where('active', true)
        ->withCount(['products' => function($query) {
            $query->where('active', true)->where('stock', '>', 0);
        }])
        ->having('products_count', '>', 0)
        ->get();

    return view('shop.index', compact('products', 'categories', 'search', 'category_id'));
}

   public function show(Product $product)
{
    // Cargar relaciones
    $product->load(['category', 'brand', 'images', 'variants']);

    $relatedProducts = Product::where('active', true)
        ->where('stock', '>', 0)
        ->where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->limit(4)
        ->get();

    return view('shop.product', compact('product', 'relatedProducts'));
}
}