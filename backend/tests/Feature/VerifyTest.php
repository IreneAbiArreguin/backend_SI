<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;

class VerifyTest extends TestCase
{
    /** @test */
    public function verificar_que_todo_funciona()
    {
        // 1. Probar factory
        $usuario = Usuario::factory()->create();
        $this->assertNotNull($usuario->id_usuario);
        echo "✓ Factory funciona\n";
        
        // 2. Probar autenticación manual
        auth()->login($usuario);
        $this->assertTrue(auth()->check());
        echo "✓ Autenticación manual funciona\n";
        
        // 3. Probar helper signIn
        $this->signIn();
        $this->assertAuthenticated();
        echo "✓ Helper signIn funciona\n";
        
    
    }
}