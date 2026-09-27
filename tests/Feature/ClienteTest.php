<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    private Usuario $consultor;

    protected function setUp(): void
    {
        parent::setUp();

        $persona = Persona::create([
            'nombre' => 'Consultor',
            'apellido' => 'Admin',
            'email' => 'admin@finora.test',
        ]);

        $this->consultor = Usuario::create([
            'persona_id' => $persona->id,
            'password' => bcrypt('password'),
            'rol' => 'CONSULTOR',
            'activo' => true,
        ]);
    }

    public function test_consultor_puede_crear_cliente(): void
    {
        $response = $this->actingAs($this->consultor)->post(route('panel.clientes.store'), [
            'nombre' => 'María',
            'apellido' => 'Gómez',
            'telefono' => '71234567',
            'email' => 'maria@ejemplo.com',
            'direccion' => 'Calle 1 # 45',
            'observaciones' => 'Cliente VIP',
        ]);

        $response->assertRedirect(route('panel.clientes.index'));
        $this->assertDatabaseHas('personas', ['email' => 'maria@ejemplo.com']);
        $this->assertDatabaseHas('clientes', ['observaciones' => 'Cliente VIP']);
    }

    public function test_consultor_puede_editar_cliente(): void
    {
        $persona = Persona::create(['nombre' => 'Pedro', 'email' => 'pedro@test.com']);
        $cliente = Cliente::create(['persona_id' => $persona->id, 'activo' => true]);

        $response = $this->actingAs($this->consultor)->put(route('panel.clientes.update', $cliente), [
            'nombre' => 'Pedro Antonio',
            'email' => 'pedro.antonio@test.com',
            'observaciones' => 'Actualizado',
        ]);

        $response->assertRedirect(route('panel.clientes.index'));
        $this->assertDatabaseHas('personas', ['nombre' => 'Pedro Antonio', 'email' => 'pedro.antonio@test.com']);
    }

    public function test_consultor_puede_buscar_clientes(): void
    {
        $p1 = Persona::create(['nombre' => 'Lucía', 'apellido' => 'Pérez', 'email' => 'lucia@test.com']);
        Cliente::create(['persona_id' => $p1->id]);

        $response = $this->actingAs($this->consultor)->get(route('panel.clientes.index', ['search' => 'Lucía']));
        $response->assertStatus(200);
        $response->assertSee('Lucía');
    }

    public function test_consultor_puede_activar_y_desactivar_cliente(): void
    {
        $persona = Persona::create(['nombre' => 'Carlos']);
        $cliente = Cliente::create(['persona_id' => $persona->id, 'activo' => true]);

        $this->actingAs($this->consultor)->patch(route('panel.clientes.toggle', $cliente));
        $this->assertDatabaseHas('clientes', ['id' => $cliente->id, 'activo' => false]);
    }
}
