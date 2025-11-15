<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosRefugioTableSeeder extends Seeder
{
     public function run()
    {
        DB::table('estados_refugio')->insert([
            ['codigo' => 'OPERATIVO', 'descripcion' => 'Refugio operativo y disponible'],
            ['codigo' => 'LLENO', 'descripcion' => 'Refugio al máximo de capacidad'],
            ['codigo' => 'MANTENIMIENTO', 'descripcion' => 'Refugio en mantenimiento'],
            ['codigo' => 'CERRADO', 'descripcion' => 'Refugio temporalmente cerrado'],
            ['codigo' => 'EMERGENCIA', 'descripcion' => 'Solo para emergencias críticas'],
        ]);
    }
}
