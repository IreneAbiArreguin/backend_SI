<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\RolSeeder;

class UsuarioModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolSeeder::class);
    }

    public function test_usuario_tiene_rol()
    {
        $usuario = Usuario::factory()->create(['id_rol' => 2]);
        $this->assertEquals(2, $usuario->id_rol);
    }
}
