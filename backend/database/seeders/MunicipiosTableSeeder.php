<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipiosTableSeeder extends Seeder
{
     
    public function run()
    {
        DB::table('municipios')->insert([
            ['nombre' => 'Cozumel', 'codigo_inegi' => '23001'],
            ['nombre' => 'Felipe Carrillo Puerto', 'codigo_inegi' => '23002'],
            ['nombre' => 'Isla Mujeres', 'codigo_inegi' => '23003'],
            ['nombre' => 'Othón P. Blanco', 'codigo_inegi' => '23004'],
            ['nombre' => 'Benito Juárez', 'codigo_inegi' => '23005'],
            ['nombre' => 'José María Morelos', 'codigo_inegi' => '23006'],
            ['nombre' => 'Lázaro Cárdenas', 'codigo_inegi' => '23007'],
            ['nombre' => 'Solidaridad', 'codigo_inegi' => '23008'],
            ['nombre' => 'Tulum', 'codigo_inegi' => '23009'],
            ['nombre' => 'Bacalar', 'codigo_inegi' => '23010'],
            ['nombre' => 'Puerto Morelos', 'codigo_inegi' => '23011'],
        ]);
    }
}
