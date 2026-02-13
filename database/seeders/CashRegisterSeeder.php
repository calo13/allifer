<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CashRegister;

class CashRegisterSeeder extends Seeder
{
    public function run(): void
    {
        CashRegister::create([
            'name' => 'Caja Principal',
            'sucursal' => 'Matriz',
            'saldo_inicial' => 500.00,
            'saldo_actual' => 500.00,
            'estado' => 'cerrada',
        ]);

        CashRegister::create([
            'name' => 'Caja 2',
            'sucursal' => 'Matriz',
            'saldo_inicial' => 300.00,
            'saldo_actual' => 300.00,
            'estado' => 'cerrada',
        ]);
    }
}