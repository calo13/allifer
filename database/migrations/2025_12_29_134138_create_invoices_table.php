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
    Schema::create('invoices', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sale_id')->constrained()->onDelete('cascade');
        
        // Datos de factura
        $table->string('serie')->nullable(); // Serie autorizada por SAT
        $table->string('numero'); // Número correlativo
        $table->string('uuid')->unique()->nullable(); // UUID de FEL
        
        // Cliente
        $table->string('nit');
        $table->string('nombre');
        $table->text('direccion')->nullable();
        
        // Montos
        $table->decimal('subtotal', 10, 2);
        $table->decimal('iva', 10, 2);
        $table->decimal('total', 10, 2);
        
        // Fechas
        $table->timestamp('fecha_emision');
        $table->timestamp('fecha_certificacion')->nullable();
        
        // XML de FEL (para integración futura)
        $table->text('xml_fel')->nullable();
        
        $table->timestamps();
        
        $table->index('numero');
        $table->index('nit');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
