<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Agregar número de pedido corto (JP001, AL002, etc)
            $table->string('order_number', 10)->unique()->after('folio');
            
            // Agregar historial de cambios de estado
            $table->json('status_history')->nullable()->after('estado');
            
            // Índice para búsquedas rápidas
            $table->index('order_number');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['order_number']);
            $table->dropColumn(['order_number', 'status_history']);
        });
    }
};