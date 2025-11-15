<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefugiosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('refugios')->insert([
            // OTHÓN P. BLANCO (Chetumal y alrededores)
            [
                'nombre' => 'Palacio de los Deportes - Chetumal',
                'direccion' => 'Av. Insurgentes esq. Niños Héroes, Centro, Chetumal',
                'capacidad_total' => 800,
                'capacidad_actual' => 0,
                'id_municipio' => 4, // Othón P. Blanco
                'estado_refugio_id' => 1,
                'telefono_contacto' => '9838349090',
                'responsable' => 'Protección Civil Estatal',
                'latitud' => 18.5004,
                'longitud' => -88.2967,
            ],
            [
                'nombre' => 'Escuela Primaria Justo Sierra Méndez',
                'direccion' => 'Calle Plutarco Elías Calles, Chetumal',
                'capacidad_total' => 300,
                'capacidad_actual' => 0,
                'id_municipio' => 4,
                'estado_refugio_id' => 1,
                'telefono_contacto' => '9831234567',
                'responsable' => 'Dirección Educación',
                'latitud' => 18.5089,
                'longitud' => -88.3021,
            ],
            [
                'nombre' => 'Centro de Salud Urbano - Chetumal',
                'direccion' => 'Av. Héroes de Chapultepec, Chetumal',
                'capacidad_total' => 150,
                'capacidad_actual' => 0,
                'id_municipio' => 4,
                'estado_refugio_id' => 1,
                'telefono_contacto' => '9838345757',
                'responsable' => 'Servicios de Salud',
                'latitud' => 18.4956,
                'longitud' => -88.2912,
            ],
            [
                'nombre' => 'Albergue Ejido Carlos A. Madrazo',
                'direccion' => 'Carretera Chetumal-Calderitas, Ejido C.A. Madrazo',
                'capacidad_total' => 200,
                'capacidad_actual' => 0,
                'id_municipio' => 4,
                'estado_refugio_id' => 1,
                'telefono_contacto' => '9831456789',
                'responsable' => 'Comisario Ejidal',
                'latitud' => 18.4567,
                'longitud' => -88.2678,
            ],

            // BENITO JUÁREZ (Cancún)
            [
                'nombre' => 'Unidad Deportiva "Jacinto Canek"',
                'direccion' => 'Región 92, Supermanzana 96, Cancún',
                'capacidad_total' => 600,
                'capacidad_actual' => 0,
                'id_municipio' => 5, // Benito Juárez
                'estado_refugio_id' => 1,
                'telefono_contacto' => '9988810101',
                'responsable' => 'Protección Civil Municipal',
                'latitud' => 21.1607,
                'longitud' => -86.8475,
            ],
            [
                'nombre' => 'Convention Center Cancún',
                'direccion' => 'Blvd. Kukulcán Km 9, Zona Hotelera, Cancún',
                'capacidad_total' => 2000,
                'capacidad_actual' => 0,
                'id_municipio' => 5,
                'estado_refugio_id' => 1,
                'telefono_contacto' => '9988810303',
                'responsable' => 'Coordinación Hoteles',
                'latitud' => 21.0909,
                'longitud' => -86.7735,
            ],

            // SOLIDARIDAD (Playa del Carmen)
            [
                'nombre' => 'Poliforum Playa del Carmen',
                'direccion' => 'Av. 20 entre Calles 8 y 10, Centro, Playa del Carmen',
                'capacidad_total' => 700,
                'capacidad_actual' => 0,
                'id_municipio' => 8, // Solidaridad
                'estado_refugio_id' => 1,
                'telefono_contacto' => '9842063030',
                'responsable' => 'Protección Civil Solidaridad',
                'latitud' => 20.6264,
                'longitud' => -87.0754,
            ],

            // TULUM
            [
                'nombre' => 'Deportivo "Mario Villanueva" Tulum',
                'direccion' => 'Av. Coba Sur, Tulum Centro',
                'capacidad_total' => 400,
                'capacidad_actual' => 0,
                'id_municipio' => 9, // Tulum
                'estado_refugio_id' => 1,
                'telefono_contacto' => '9848714050',
                'responsable' => 'Dirección Municipal Tulum',
                'latitud' => 20.2099,
                'longitud' => -87.4634,
            ],

            // BACALAR
            [
                'nombre' => 'Casa de la Cultura Bacalar',
                'direccion' => 'Av. 5 entre Calles 26 y 28, Bacalar',
                'capacidad_total' => 250,
                'capacidad_actual' => 0,
                'id_municipio' => 10, // Bacalar
                'estado_refugio_id' => 1,
                'telefono_contacto' => '9831231234',
                'responsable' => 'Cultura Municipal',
                'latitud' => 18.6783,
                'longitud' => -88.3912,
            ],
        ]);
    }
}
