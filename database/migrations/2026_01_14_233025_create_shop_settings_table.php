<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;  // ← AGREGAR ESTA LÍNEA

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
        
        // Insertar configuración por defecto
        DB::table('shop_settings')->insert([
            ['key' => 'limite_sin_login', 'value' => '500.00', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'requiere_aprobacion_sin_login', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'max_pedidos_por_ip', 'value' => '3', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_settings');
    }
};