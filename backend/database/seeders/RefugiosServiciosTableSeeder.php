<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefugiosServiciosTableSeeder extends Seeder
{ 
    public function run()
    {
        DB::table('refugios_servicios')->insert([
            ['nombre' => 'Atención Médica Básica', 'descripcion' => 'Primeros auxilios y consulta básica'],
            ['nombre' => 'Medicamentos Esenciales', 'descripcion' => 'Botiquín y medicamentos básicos'],
            ['nombre' => 'Alimentación', 'descripcion' => 'Despensas y comidas calientes'],
            ['nombre' => 'Agua Potable', 'descripcion' => 'Suministro de agua embotellada'],
            ['nombre' => 'Alojamiento Temporal', 'descripcion' => 'Colchonetas y áreas para dormir'],
            ['nombre' => 'Sanitarios', 'descripcion' => 'Servicios sanitarios y regaderas'],
            ['nombre' => 'Información y Comunicación', 'descripcion' => 'Punto de información y teléfono'],
            ['nombre' => 'Rescate Acuático', 'descripcion' => 'Equipo para rescate en inundaciones'],
            ['nombre' => 'Atención a Mascotas', 'descripcion' => 'Área para alojar animales domésticos'],
            ['nombre' => 'Apoyo Psicológico', 'descripcion' => 'Atención emocional y crisis'],
            ['nombre' => 'Carga de Dispositivos', 'descripcion' => 'Puntos de carga para celulares'],
            ['nombre' => 'Transporte', 'descripcion' => 'Coordinación de evacuación'],
        ]);
    }
}
