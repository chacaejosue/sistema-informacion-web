<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    /**
     * Protección de seguridad: garantiza que los tests SOLO se ejecuten
     * sobre una base de datos SQLite en memoria (:memory:) antes de que
     * RefreshDatabase pueda ejecutar cualquier migración o modificación de tablas.
     */
    protected function setUp(): void
    {
        if (! $this->app) {
            $this->refreshApplication();
        }

        $connection = (string) config('database.default');
        $driver     = (string) config("database.connections.{$connection}.driver");
        $database   = (string) config("database.connections.{$connection}.database");

        if ($driver !== 'sqlite' || $database !== ':memory:') {
            throw new RuntimeException(
                "¡PROTECCIÓN DE SEGURIDAD ACTIVADA! Se abortó la ejecución de pruebas. " .
                "La conexión efectiva resolved por Laravel es '{$connection}' (driver: '{$driver}', base de datos: '{$database}'). " .
                "Por seguridad del proyecto Finora, las pruebas SOLO tienen permitido ejecutarse sobre SQLite en memoria (:memory:)."
            );
        }

        parent::setUp();
    }
}
