<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tablas maestras (sin dependencias)
        $this->call(RolesTableSeeder::class);
        $this->call(EstadosReporteTableSeeder::class);
        $this->call(EstadosRefugioTableSeeder::class);
        $this->call(NivelesRiesgoTableSeeder::class);
        $this->call(MunicipiosTableSeeder::class);
        $this->call(RefugiosServiciosTableSeeder::class);

        // 2. Tablas principales que dependen de las anteriores
        $this->call(UsuariosTableSeeder::class);
        $this->call(RefugiosTableSeeder::class);

        // 3. Tablas con relaciones entre varias entidades
        $this->call(RefugiosServiciosRelTableSeeder::class);
        $this->call(ZonasRiesgoTableSeeder::class);
    }
}