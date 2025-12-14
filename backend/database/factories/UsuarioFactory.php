<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'telefono' => $this->faker->phoneNumber(),
            'ubicacion' => $this->faker->address(),
            'latitud' => $this->faker->latitude(),
            'longitud' => $this->faker->longitude(),
            'id_rol' => 2,
            'email_verificado_at' => now(),
        ];
    }

    public function unverified()
    {
        return $this->state(fn () => [
            'email_verificado_at' => null,
        ]);
    }
}

