<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $cajeroRole = Role::where('name', 'cajero')->first();
        $clienteRole = Role::where('name', 'cliente')->first();

        // Usuario Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@tienda.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'active' => true,
        ]);

        // Usuario Cajero
        User::create([
            'name' => 'María González',
            'email' => 'lacho',
            'password' => Hash::make('lacho'),
            'role_id' => $cajeroRole->id,
            'active' => true,
        ]);

        // Usuario Cliente
        User::create([
            'name' => 'Carlos Pérez',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password'),
            'role_id' => $clienteRole->id,
            'active' => true,
        ]);
    }
}