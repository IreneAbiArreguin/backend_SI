<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelesRiesgoTableSeeder extends Seeder
{
   public function run()
    {
        DB::table('niveles_riesgo')->insert([
            ['codigo' => 'BAJO', 'descripcion' => 'Riesgo bajo - Precauciones mínimas'],
            ['codigo' => 'MODERADO', 'descripcion' => 'Riesgo moderado - Mantenerse alerta'],
            ['codigo' => 'ALTO', 'descripcion' => 'Riesgo alto - Tomar precauciones'],
            ['codigo' => 'MUY_ALTO', 'descripcion' => 'Riesgo muy alto - Evacuar si es necesario'],
            ['codigo' => 'CRITICO', 'descripcion' => 'Riesgo crítico - Evacuación inmediata'],
        ]);
    }
}
