<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosTableSeeder extends Seeder
{
     public function run(){ 
        DB::table('usuarios')->insert([
            [
                'nombre' => 'Admin',
                'apellido' => 'Sistema',
                'email' => 'admin@inundaciones.com',
                'password' => Hash::make('4444'),
                'telefono' => '6671234567',
                'ubicacion' => 'Oficina Central',
                'latitud' => 24.799396,
                'longitud' => -107.389566,
                'id_rol' => 1,
                'email_verificado_at' => now(),
            ]
        ]);
    }
}

