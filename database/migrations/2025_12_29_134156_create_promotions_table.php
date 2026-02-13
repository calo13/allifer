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
    Schema::create('promotions', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        
        $table->enum('type', ['porcentaje', 'monto_fijo', '2x1', '3x2', 'combo'])->default('porcentaje');
        $table->decimal('descuento_porcentaje', 5, 2)->nullable();
        $table->decimal('descuento_monto', 10, 2)->nullable();
        
        // Aplicabilidad
        $table->boolean('aplica_online')->default(true);
        $table->boolean('aplica_tienda')->default(true);
        
        // Vigencia - CAMBIAMOS A NULLABLE
        $table->timestamp('fecha_inicio')->nullable();
        $table->timestamp('fecha_fin')->nullable();
        
        // Días de semana
        $table->json('dias_semana')->nullable();
        
        $table->boolean('active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
