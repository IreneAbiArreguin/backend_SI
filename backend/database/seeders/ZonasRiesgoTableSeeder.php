<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonasRiesgoTableSeeder extends Seeder
{
     public function run()
    {
        DB::table('zonas_riesgo')->insert([
            [
                'identificador' => 'CHETUMAL_CENTRO_HISTORICO',
                'id_nivel' => 4, // Muy Alto
                'poligono' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [18.5020, -88.3050],
                        [18.5030, -88.3000],
                        [18.4980, -88.2980],
                        [18.4970, -88.3030],
                        [18.5020, -88.3050]
                    ]]
                ]),
            ],
            [
                'identificador' => 'BACALAR_ZONA_LAGUNA',
                'id_nivel' => 3, // Alto
                'poligono' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [18.6800, -88.4000],
                        [18.6820, -88.3950],
                        [18.6750, -88.3900],
                        [18.6730, -88.3980],
                        [18.6800, -88.4000]
                    ]]
                ]),
            ],
            [
                'identificador' => 'CANCUN_ZONA_HOTELERA_NORTE',
                'id_nivel' => 3, // Alto
                'poligono' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [21.1600, -86.8300],
                        [21.1620, -86.8200],
                        [21.1550, -86.8150],
                        [21.1530, -86.8250],
                        [21.1600, -86.8300]
                    ]]
                ]),
            ],
            [
                'identificador' => 'PLAYA_DEL_CARMEN_CENTRO',
                'id_nivel' => 2, // Moderado
                'poligono' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [20.6280, -87.0780],
                        [20.6300, -87.0720],
                        [20.6250, -87.0700],
                        [20.6230, -87.0760],
                        [20.6280, -87.0780]
                    ]]
                ]),
            ],
            [
                'identificador' => 'TULUM_ZONA_ARCHEOLOGICA',
                'id_nivel' => 2, // Moderado
                'poligono' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [20.2150, -87.4300],
                        [20.2170, -87.4250],
                        [20.2120, -87.4220],
                        [20.2100, -87.4280],
                        [20.2150, -87.4300]
                    ]]
                ]),
            ],
            [
                'identificador' => 'CALDERITAS_CHETUMAL',
                'id_nivel' => 4, // Muy Alto
                'poligono' => json_encode([
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [18.5500, -88.2500],
                        [18.5520, -88.2450],
                        [18.5450, -88.2420],
                        [18.5430, -88.2480],
                        [18.5500, -88.2500]
                    ]]
                ]),
            ],
        ]);
    }
}
