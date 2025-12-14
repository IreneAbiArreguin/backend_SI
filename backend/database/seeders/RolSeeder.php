<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id_rol' => 1,
                'nombre' => 'Administrador',
                'descripcion' => 'Acceso completo al sistema',
            ],
            [
                'id_rol' => 2,
                'nombre' => 'Moderador',
                'descripcion' => 'Puede verificar y moderar reportes',
            ],
            [
                'id_rol' => 3,
                'nombre' => 'Ciudadano',
                'descripcion' => 'Usuario regular que reporta inundaciones',
            ],
            [
                'id_rol' => 4,
                'nombre' => 'Rescatista',
                'descripcion' => 'Personal de rescate y emergencias',
            ],
        ]);
    }
}
