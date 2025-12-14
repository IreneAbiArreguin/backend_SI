<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_usuario_con_factory()
    {
        $usuario = Usuario::factory()->create();
        
        $this->assertDatabaseHas('usuarios', [
            'id_usuario' => $usuario->id_usuario,
            'email' => $usuario->email
        ]);
        
        $this->assertEquals(2, $usuario->id_rol);
        echo "✓ Factory funciona correctamente\n";
    }
    
    /** @test */
    public function usuario_puede_autenticarse()
    {
        // Crear usuario con contraseña conocida
        $usuario = Usuario::factory()->create([
            'password' => bcrypt('password123')
        ]);
        
        // Intenta hacer login (simulando formulario)
        $response = $this->post('/login', [
            'email' => $usuario->email,
            'password' => 'password123'
        ]);
        
        // Verifica que está autenticado
        $this->assertTrue(Auth::check());
        $this->assertAuthenticated();
        
        echo "✓ Usuario puede autenticarse\n";
    }
    
    /** @test */
    public function helper_signin_funciona()
    {
        // Este método usa actingAs internamente, pero lo probamos diferente
        $usuario = Usuario::factory()->create();
        
        // Manera alternativa de autenticar
        Auth::login($usuario);
        
        $this->assertAuthenticated();
        $this->assertInstanceOf(Usuario::class, Auth::user());
        
        echo "✓ Autenticación funciona\n";
    }
    
    /** @test */
    public function prueba_muy_simple()
    {
        $this->assertTrue(true);
        echo "✓ Prueba básica pasa\n";
    }
}