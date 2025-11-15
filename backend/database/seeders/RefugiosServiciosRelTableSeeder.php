<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefugiosServiciosRelTableSeeder extends Seeder
{
     public function run()
    {
        DB::table('refugios_servicios_rel')->insert([
            // Palacio de los Deportes - Chetumal (Refugio 1)
            ['id_refugio' => 1, 'id_servicio' => 1, 'disponible' => true],
            ['id_refugio' => 1, 'id_servicio' => 2, 'disponible' => true],
            ['id_refugio' => 1, 'id_servicio' => 3, 'disponible' => true],
            ['id_refugio' => 1, 'id_servicio' => 4, 'disponible' => true],
            ['id_refugio' => 1, 'id_servicio' => 5, 'disponible' => true],
            ['id_refugio' => 1, 'id_servicio' => 6, 'disponible' => true],
            ['id_refugio' => 1, 'id_servicio' => 7, 'disponible' => true],
            ['id_refugio' => 1, 'id_servicio' => 11, 'disponible' => true],
            
            // Escuela Primaria - Chetumal (Refugio 2)
            ['id_refugio' => 2, 'id_servicio' => 1, 'disponible' => true],
            ['id_refugio' => 2, 'id_servicio' => 3, 'disponible' => true],
            ['id_refugio' => 2, 'id_servicio' => 4, 'disponible' => true],
            ['id_refugio' => 2, 'id_servicio' => 5, 'disponible' => true],
            ['id_refugio' => 2, 'id_servicio' => 7, 'disponible' => true],
            
            // Centro de Salud - Chetumal (Refugio 3)
            ['id_refugio' => 3, 'id_servicio' => 1, 'disponible' => true],
            ['id_refugio' => 3, 'id_servicio' => 2, 'disponible' => true],
            ['id_refugio' => 3, 'id_servicio' => 10, 'disponible' => true],
            
            // Albergue Ejido (Refugio 4)
            ['id_refugio' => 4, 'id_servicio' => 3, 'disponible' => true],
            ['id_refugio' => 4, 'id_servicio' => 4, 'disponible' => true],
            ['id_refugio' => 4, 'id_servicio' => 5, 'disponible' => true],
            
            // Unidad Deportiva Cancún (Refugio 5)
            ['id_refugio' => 5, 'id_servicio' => 1, 'disponible' => true],
            ['id_refugio' => 5, 'id_servicio' => 3, 'disponible' => true],
            ['id_refugio' => 5, 'id_servicio' => 4, 'disponible' => true],
            ['id_refugio' => 5, 'id_servicio' => 5, 'disponible' => true],
            ['id_refugio' => 5, 'id_servicio' => 6, 'disponible' => true],
            ['id_refugio' => 5, 'id_servicio' => 7, 'disponible' => true],
            ['id_refugio' => 5, 'id_servicio' => 8, 'disponible' => true],
            
            // Convention Center Cancún (Refugio 6)
            ['id_refugio' => 6, 'id_servicio' => 1, 'disponible' => true],
            ['id_refugio' => 6, 'id_servicio' => 2, 'disponible' => true],
            ['id_refugio' => 6, 'id_servicio' => 3, 'disponible' => true],
            ['id_refugio' => 6, 'id_servicio' => 4, 'disponible' => true],
            ['id_refugio' => 6, 'id_servicio' => 5, 'disponible' => true],
            ['id_refugio' => 6, 'id_servicio' => 6, 'disponible' => true],
            ['id_refugio' => 6, 'id_servicio' => 7, 'disponible' => true],
            ['id_refugio' => 6, 'id_servicio' => 9, 'disponible' => true],
            ['id_refugio' => 6, 'id_servicio' => 10, 'disponible' => true],
            ['id_refugio' => 6, 'id_servicio' => 11, 'disponible' => true],
            ['id_refugio' => 6, 'id_servicio' => 12, 'disponible' => true],
        ]);
    }
}
