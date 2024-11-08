<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AddPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Desarrollador = Role::where('name', 'Desarrollador')->first();
        $rol = Role::where('name', 'Administrador')->first();

        $permiso = Permission::create(['name' => 'expediente.destroy']);
        $rol->givePermissionTo($permiso);
        $Desarrollador->givePermissionTo($permiso);
    }
}
