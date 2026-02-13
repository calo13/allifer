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
    Schema::table('customers', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->after('id');
        $table->string('nombre');
        $table->string('nit')->default('CF');
        $table->string('email')->nullable();
        $table->string('telefono')->nullable();
        $table->text('direccion')->nullable();
        $table->enum('tipo', ['consumidor_final', 'empresa'])->default('consumidor_final');
        $table->decimal('descuento_porcentaje', 5, 2)->default(0);
        $table->decimal('limite_credito', 10, 2)->default(0);
        $table->decimal('total_gastado', 10, 2)->default(0);
        $table->boolean('activo')->default(true);
        
        $table->index('nit');
        $table->index('email');
        $table->index('telefono');
    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('customers', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn([
            'user_id',
            'nombre',
            'nit',
            'email',
            'telefono',
            'direccion',
            'tipo',
            'descuento_porcentaje',
            'limite_credito',
            'total_gastado',
            'activo',
        ]);
    });
}
};
