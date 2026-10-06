<?php

namespace Tests\Feature;

use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrearConsultorCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_comando_crea_el_primer_consultor_sin_credenciales_hardcodeadas(): void
    {
        $this->artisan('finora:crear-consultor')
            ->expectsQuestion('Nombre del consultor', 'Consultora Inicial')
            ->expectsQuestion('Correo electrónico', 'consultora.inicial@test.com')
            ->expectsQuestion('Contraseña (mínimo 12 caracteres)', 'Password123!@#')
            ->expectsQuestion('Confirmar contraseña', 'Password123!@#')
            ->expectsOutput('Consultor registrado correctamente. Ya puede iniciar sesión en Finora.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('personas', [
            'nombre' => 'Consultora Inicial',
            'email' => 'consultora.inicial@test.com',
        ]);
        $this->assertDatabaseHas('usuarios', [
            'rol' => 'CONSULTOR',
            'activo' => true,
        ]);
    }

    public function test_el_comando_rechaza_un_correo_duplicado(): void
    {
        $persona = Persona::create([
            'nombre' => 'Consultora Existente',
            'email' => 'existente@test.com',
        ]);
        Usuario::create([
            'persona_id' => $persona->id,
            'password' => 'Password123!@#',
            'rol' => 'CONSULTOR',
            'activo' => true,
        ]);

        $this->artisan('finora:crear-consultor')
            ->expectsOutput('Ya existe una cuenta CONSULTOR. Use el panel para crear colaboradores.')
            ->assertExitCode(1);
    }
}
