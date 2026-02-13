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
    Schema::create('cash_registers', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Caja 1, Caja Principal, etc.
        $table->string('sucursal')->nullable();
        $table->decimal('saldo_inicial', 10, 2)->default(0);
        $table->decimal('saldo_actual', 10, 2)->default(0);
        $table->enum('estado', ['abierta', 'cerrada'])->default('cerrada');
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Usuario asignado
        $table->timestamp('fecha_apertura')->nullable();
        $table->timestamp('fecha_cierre')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_registers');
    }
};
