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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_variant_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('type', ['entrada', 'salida', 'ajuste', 'devolucion']);
            $table->integer('quantity');
            $table->integer('stock_antes');
            $table->integer('stock_despues');
            $table->string('motivo'); // Compra, Venta, Daño, Vencimiento, etc.
            $table->text('notas')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Quien registró
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
