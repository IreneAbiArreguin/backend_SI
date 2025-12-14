<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Usuario;
use Illuminate\Contracts\Auth\Authenticatable;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    /**
     * Helper para autenticar un usuario en las pruebas
     * 
     * @param Usuario|null $usuario
     * @return Usuario&Authenticatable
     */
    protected function signIn(?Usuario $usuario = null): Usuario
    {
        /** @var Usuario&Authenticatable $usuario */
        $usuario = $usuario ?? Usuario::factory()->create();
        $this->actingAs($usuario);
        return $usuario;
    }
    
    /**
     * Helper para autenticar un usuario administrador
     * 
     * @return Usuario&Authenticatable
     */
    protected function signInAsAdmin(): Usuario
    {
        /** @var Usuario&Authenticatable $usuario */
        $usuario = Usuario::factory()->create(['id_rol' => 1]);
        $this->actingAs($usuario);
        return $usuario;
    }
    
    /**
     * Helper para autenticar un usuario regular
     * 
     * @return Usuario&Authenticatable
     */
    protected function signInAsUser(): Usuario
    {
        /** @var Usuario&Authenticatable $usuario */
        $usuario = Usuario::factory()->create(['id_rol' => 2]);
        $this->actingAs($usuario);
        return $usuario;
    }
}