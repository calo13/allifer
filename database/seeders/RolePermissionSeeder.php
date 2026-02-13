<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Resetear cache de roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear Permisos
        $permissions = [
            // Productos
            'ver-productos',
            'crear-productos',
            'editar-productos',
            'eliminar-productos',

            // Stock
            'ver-stock',
            'registrar-movimientos-stock',
            'anular-movimientos-stock',

            // Ventas
            'ver-ventas',
            'crear-ventas',
            'anular-ventas',
            'acceder-pos',
            'vender-precio-mayorista',

            // Caja
            'abrir-caja',
            'cerrar-caja',
            'ver-caja',

            // Usuarios
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',

            // Reportes
            'ver-reportes',
            'exportar-reportes',

            // Categorías, Marcas, Proveedores
            'gestionar-categorias',
            'gestionar-marcas',
            'gestionar-proveedores',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear Roles y asignar permisos

        // 1. ADMINISTRADOR - Acceso total
        $adminRole = Role::create(['name' => 'Administrador']);
        $adminRole->givePermissionTo(Permission::all());

        // 2. VENDEDOR MOSTRADOR - Ventas rápidas
        $vendedorRole = Role::create(['name' => 'Vendedor']);
        $vendedorRole->givePermissionTo([
            'ver-productos',
            'ver-stock',
            'ver-ventas',
            'crear-ventas',
            'acceder-pos',
            'abrir-caja',
            'cerrar-caja',
            'ver-caja',
        ]);

        // 3. VENDEDOR MAYORISTA - Precios especiales
        $mayoristaRole = Role::create(['name' => 'Vendedor Mayorista']);
        $mayoristaRole->givePermissionTo([
            'ver-productos',
            'ver-stock',
            'ver-ventas',
            'crear-ventas',
            'acceder-pos',
            'vender-precio-mayorista',
            'abrir-caja',
            'cerrar-caja',
            'ver-caja',
        ]);

        // 4. VENDEDOR ONLINE - Carrito de compras
        $onlineRole = Role::create(['name' => 'Vendedor Online']);
        $onlineRole->givePermissionTo([
            'ver-productos',
            'ver-ventas',
            'crear-ventas',
        ]);

        // 5. CLIENTE - Usuarios registrados en la web
        $clienteRole = Role::create(['name' => 'Cliente']);
        $clienteRole->givePermissionTo([
            'ver-productos',
            'crear-ventas',
        ]);

        // Asignar rol de Administrador al primer usuario
        // Crear usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@tienda.com',
            'password' => bcrypt('123'),
            'active' => true,
        ]);

        $admin->assignRole('Administrador');
    }
}
