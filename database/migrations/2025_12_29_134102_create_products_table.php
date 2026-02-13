<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('sku')->unique()->nullable(); // ← ahora nullable
        $table->string('barcode')->nullable()->unique();
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        
        // Precios
        $table->decimal('precio_costo', 10, 2)->default(0);
        $table->decimal('precio_venta', 10, 2);
        $table->decimal('precio_mayorista', 10, 2)->nullable();
        
        // Inventario
        $table->integer('stock')->default(0);
        $table->integer('stock_minimo')->default(5);
        
        // Relaciones
        $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
        
        // Imagen
        $table->string('image')->nullable();
        
        // Estado
        $table->boolean('active')->default(true);
        $table->boolean('featured')->default(false);
        
        $table->timestamps();
        
        $table->index('sku');
        $table->index('barcode');
        $table->index('active');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
