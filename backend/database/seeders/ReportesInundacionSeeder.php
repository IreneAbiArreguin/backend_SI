<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ReportesInundacionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_MX');

        $calles = ['Paseo de Montejo', 'Calle 60', 'Calle 50', 'Calle 65', 'Av. Itzáes'];
        $colonias = ['Centro', 'Chuburná', 'Col. México', 'Las Américas', 'Francisco de Montejo'];

        for ($i = 0; $i < 15; $i++) {
            DB::table('reportes_inundacion')->insert([
                'id_usuario'        => 2, // ← TODOS del usuario 2
                'id_municipio'      => $faker->numberBetween(1, 8),
                'estado_reporte_id' => $faker->randomElement([1, 2, 3, 4]),
                'nivel_afectacion'  => $faker->randomElement(['Leve', 'Moderado', 'Severo', 'Crítico']),
                'metodo_origen'     => $faker->randomElement(['web_usuario', 'app_movil', 'whatsapp']),
                'fecha_suceso'      => $faker->dateTimeBetween('-45 days', 'now'),
                'prioridad'         => $faker->numberBetween(1, 3),
                'calle_principal'   => $faker->randomElement($calles),
                'cruzamiento1'      => $faker->randomElement($calles),
                'cruzamiento2'      => $faker->optional(0.5)->randomElement($calles),
                'colonia'           => $faker->randomElement($colonias),
                'cp'                => $faker->postcode,
                'descripcion'       => $faker->realText(200),
                'latitud'           => $faker->latitude(20.9, 21.1),
                'longitud'          => $faker->longitude(-89.7, -89.5),
                'verificado_por'    => $faker->optional(0.3)->numberBetween(1, 10),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}