<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            // categorias
            'ver-categoria',
            'crear-categoria',
            'editar-categoria',
            'eliminar-categoria',

            // compra
            'ver-compra',
            'crear-compra',
            'mostrar-compra',
            'eliminar-compra',

            // persona (cliente)
            'ver-persona',
            'crear-persona',
            'editar-persona',
            'eliminar-persona',

            // producto
            'ver-producto',
            'crear-producto',
            'editar-producto',
            'eliminar-producto',

            // proveedor
            'ver-proveedor',
            'crear-proveedor',
            'editar-proveedor',
            'eliminar-proveedor',

            // venta
            'ver-venta',
            'crear-venta',
            'mostrar-venta',
            'eliminar-venta',

            // roles
            'ver-role',
            'crear-role',
            'editar-role',
            'eliminar-role',

            // usuarios
            'ver-user',
            'crear-user',
            'editar-user',
            'eliminar-user',
        ];

        foreach($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}
