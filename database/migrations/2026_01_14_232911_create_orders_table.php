<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->enum('tipo', ['invitado', 'registrado'])->default('invitado');
            
            // Datos del cliente (si es invitado)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nombre_cliente');
            $table->string('telefono_cliente');
            $table->string('email_cliente')->nullable();
            $table->text('direccion_entrega');
            $table->text('notas')->nullable();
            
            // Totales
            $table->decimal('subtotal', 10, 2);
            $table->decimal('iva', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            
            // Pago y estado
            $table->enum('metodo_pago', ['efectivo', 'transferencia', 'tarjeta'])->default('efectivo');
            $table->enum('estado', [
                'pendiente',      // Esperando aprobación
                'aprobado',       // Admin aprobó
                'en_proceso',     // Preparando pedido
                'enviado',        // En camino
                'entregado',      // Completado
                'cancelado'       // Cancelado
            ])->default('pendiente');
            
            // Tracking
            $table->foreignId('aprobado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('aprobado_at')->nullable();
            $table->string('ip_address')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};