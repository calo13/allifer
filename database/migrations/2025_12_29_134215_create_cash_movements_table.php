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
    Schema::create('cash_movements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cash_register_id')->constrained()->onDelete('cascade');
        $table->enum('type', ['apertura', 'cierre', 'venta', 'retiro', 'ingreso'])->default('venta');
        $table->decimal('monto', 10, 2);
        $table->text('descripcion')->nullable();
        $table->foreignId('sale_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_movements');
    }
};
