<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosReporteTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('estados_reporte')->insert([
            ['codigo' => 'REPORTADO', 'descripcion' => 'Reporte inicial recibido'],
            ['codigo' => 'EN_VERIFICACION', 'descripcion' => 'Equipos verificando la situación'],
            ['codigo' => 'CONFIRMADO', 'descripcion' => 'Inundación confirmada en zona'],
            ['codigo' => 'EVACUACION', 'descripcion' => 'En proceso de evacuación'],
            ['codigo' => 'CONTROLADO', 'descripcion' => 'Situación bajo control'],
            ['codigo' => 'RESUELTO', 'descripcion' => 'Inundación resuelta'],
            ['codigo' => 'FALSA_ALARMA', 'descripcion' => 'Reporte sin fundamento'],
        ]);
    }
}
