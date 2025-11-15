<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
   public function run(){
        DB::table('roles')->insert([
            ['nombre' => 'Administrador', 'descripcion' => 'Acceso completo al sistema'],
            ['nombre' => 'Moderador', 'descripcion' => 'Puede verificar y moderar reportes'],
            ['nombre' => 'Ciudadano', 'descripcion' => 'Usuario regular que reporta inundaciones'],
            ['nombre' => 'Rescatista', 'descripcion' => 'Personal de rescate y emergencias'],
        ]);
    }
}
