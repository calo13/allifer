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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sale_id')->constrained()->onDelete('cascade');
        $table->enum('metodo', ['efectivo', 'tarjeta', 'transferencia', 'recurrente', 'cheque'])->default('efectivo');
        $table->decimal('monto', 10, 2);
        $table->string('referencia')->nullable(); // Número de autorización, etc.
        $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('aprobado');
        $table->text('notas')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
