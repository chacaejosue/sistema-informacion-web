<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ConsultorSeeder extends Seeder
{
    /**
     * Ejecuta el seeder para registrar la cuenta inicial del consultor.
     */
    public function run(): void
    {
        // Solicitar los datos del consultor.
        $nombre = trim($this->command->ask('Nombre del consultor'));
        $email = strtolower(trim($this->command->ask('Correo electrónico')));

        // Validar los datos.
        if (
            $nombre === '' ||
            mb_strlen($nombre) > 100 ||
            ! filter_var($email, FILTER_VALIDATE_EMAIL) ||
            strlen($email) > 255
        ) {
            $this->command->error('Nombre o correo electrónico no válido.');
            return;
        }

        // Evitar registros duplicados.
        if (Persona::where('email', $email)->exists()) {
            $this->command->warn('Ya existe una persona con ese correo.');
            return;
        }

        // Solicitar la contraseña sin mostrarla.
        $password = $this->command->secret('Contraseña (mínimo 12 caracteres)');
        $confirmacion = $this->command->secret('Confirmar contraseña');

        if (
            ! is_string($password) ||
            strlen($password) < 12 ||
            $password !== $confirmacion
        ) {
            $this->command->error('La contraseña no es válida o no coincide.');
            return;
        }

        // Registrar ambos datos en una transacción.
        DB::transaction(function () use ($nombre, $email, $password) {

            $persona = Persona::create([
                'nombre' => $nombre,
                'email' => $email,
            ]);

            Usuario::create([
                'persona_id' => $persona->id,
                'password' => Hash::make($password),
                'rol' => 'CONSULTOR',
                'activo' => true,
            ]);
        });

        $this->command->info('Consultor registrado correctamente.');
    }
}