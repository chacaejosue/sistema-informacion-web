<?php

namespace Tests\Feature;

use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAndPanelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Un visitante sin sesión no puede entrar al panel y es redirigido al login.
     */
    public function test_invitado_no_puede_acceder_al_panel(): void
    {
        $response = $this->get('/panel');

        $response->assertRedirect('/login');
    }

    /**
     * Un CONSULTOR autenticado activo puede acceder al panel.
     */
    public function test_consultor_autenticado_puede_acceder_al_panel(): void
    {
        $persona = Persona::create([
            'nombre' => 'Josué',
            'apellido' => 'Chacae',
            'email' => 'consultor@finora.test',
        ]);

        $usuario = Usuario::create([
            'persona_id' => $persona->id,
            'password' => Hash::make('Password123!@#'),
            'rol' => 'CONSULTOR',
            'activo' => true,
        ]);

        $response = $this->actingAs($usuario)->get('/panel');

        $response->assertStatus(200);
        $response->assertSee('¡Bienvenido, Josué!');
        $response->assertSee('CONSULTOR');
    }

    /**
     * Las credenciales incorrectas son rechazadas.
     */
    public function test_credenciales_incorrectas_son_rechazadas(): void
    {
        $persona = Persona::create([
            'nombre' => 'Test',
            'email' => 'prueba@finora.test',
        ]);

        Usuario::create([
            'persona_id' => $persona->id,
            'password' => Hash::make('ClaveCorrecta123!'),
            'rol' => 'CONSULTOR',
            'activo' => true,
        ]);

        $response = $this->post('/login', [
            'identity' => 'prueba@finora.test',
            'password' => 'ClaveIncorrecta',
        ]);

        $response->assertSessionHasErrors('identity');
        $this->assertGuest();
    }

    /**
     * Las cuentas inactivas no pueden iniciar sesión.
     */
    public function test_usuario_inactivo_no_puede_iniciar_sesion(): void
    {
        $persona = Persona::create([
            'nombre' => 'Inactivo',
            'email' => 'inactivo@finora.test',
        ]);

        Usuario::create([
            'persona_id' => $persona->id,
            'password' => Hash::make('Password123!@#'),
            'rol' => 'CONSULTOR',
            'activo' => false,
        ]);

        $response = $this->post('/login', [
            'identity' => 'inactivo@finora.test',
            'password' => 'Password123!@#',
        ]);

        $response->assertSessionHasErrors('identity');
        $this->assertGuest();
    }

    /**
     * El cierre de sesión funciona correctamente.
     */
    public function test_cierre_de_sesion_funciona_correctamente(): void
    {
        $persona = Persona::create([
            'nombre' => 'Consultor',
            'email' => 'logout@finora.test',
        ]);

        $usuario = Usuario::create([
            'persona_id' => $persona->id,
            'password' => Hash::make('Password123!@#'),
            'rol' => 'CONSULTOR',
            'activo' => true,
        ]);

        $response = $this->actingAs($usuario)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Los usuarios con otros roles (COLABORADOR, CLIENTE) no pueden acceder al panel del consultor.
     */
    public function test_otros_roles_no_pueden_acceder_al_panel_del_consultor(): void
    {
        $personaColaborador = Persona::create([
            'nombre' => 'Colaborador',
            'email' => 'colaborador@finora.test',
        ]);

        $usuarioColaborador = Usuario::create([
            'persona_id' => $personaColaborador->id,
            'password' => Hash::make('Password123!@#'),
            'rol' => 'COLABORADOR',
            'activo' => true,
        ]);

        $personaCliente = Persona::create([
            'nombre' => 'Cliente',
            'email' => 'cliente@finora.test',
        ]);

        $usuarioCliente = Usuario::create([
            'persona_id' => $personaCliente->id,
            'password' => Hash::make('Password123!@#'),
            'rol' => 'CLIENTE',
            'activo' => true,
        ]);

        // Intentar acceder como COLABORADOR
        $responseColaborador = $this->actingAs($usuarioColaborador)->get('/panel');
        $responseColaborador->assertStatus(403);

        // Intentar acceder como CLIENTE
        $responseCliente = $this->actingAs($usuarioCliente)->get('/panel');
        $responseCliente->assertStatus(403);
    }

    /**
     * Un consultor autenticado que accede a /login es redirigido al panel.
     */
    public function test_consultor_autenticado_visitando_login_es_redirigido_al_panel(): void
    {
        $persona = Persona::create([
            'nombre' => 'Consultor',
            'email' => 'redirect@finora.test',
        ]);

        $usuario = Usuario::create([
            'persona_id' => $persona->id,
            'password' => Hash::make('Password123!@#'),
            'rol' => 'CONSULTOR',
            'activo' => true,
        ]);

        $response = $this->actingAs($usuario)->get('/login');

        $response->assertRedirect('/panel');
    }
}
