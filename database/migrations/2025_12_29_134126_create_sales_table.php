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
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->string('folio')->unique();
        $table->enum('tipo_venta', ['presencial', 'online'])->default('presencial');
        $table->enum('tipo_documento', ['ticket', 'factura'])->default('ticket');
        
        // Cliente
        $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
        $table->string('nit_cliente')->default('CF');
        $table->string('nombre_cliente');
        
        // Montos
        $table->decimal('subtotal', 10, 2);
        $table->decimal('iva', 10, 2)->default(0);
        $table->decimal('descuento', 10, 2)->default(0);
        $table->decimal('total', 10, 2);
        
        // Pago
        $table->enum('metodo_pago', ['efectivo', 'tarjeta', 'transferencia', 'recurrente', 'mixto'])->default('efectivo');
        $table->enum('estado', ['pendiente', 'pagado', 'cancelado', 'reembolsado'])->default('pendiente');
        
        // Tracking
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // CAMBIAMOS ESTA LÍNEA - solo unsignedBigInteger sin foreign key
        $table->unsignedBigInteger('cash_register_id')->nullable();
        
        $table->timestamp('fecha_venta')->useCurrent();
        $table->timestamps();
        
        $table->index('folio');
        $table->index('fecha_venta');
        $table->index('estado');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
