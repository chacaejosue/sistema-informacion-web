<?php

namespace App\Services;

use App\Models\Configuracion;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TipoCambioService
{
    private const MODE_KEY = 'finora.exchange_rate.mode';

    private const MANUAL_KEY = 'finora.exchange_rate.manual';

    private const OFFICIAL_KEY = 'finora.exchange_rate.official';

    public function bolivianosPorDolar(): float
    {
        if ($this->fuente() === 'MANUAL') {
            return $this->manual() ?? (float) config('finora.usd_to_bob_fallback', 12.00);
        }

        return (float) Cache::remember(
            'finora.tipo-cambio.usd-bob.oficial',
            now()->endOfDay()->addMinutes(5),
            fn (): float => $this->guardarTasaOficial($this->consultarBancoCentral()),
        );
    }

    /**
     * @return array{tasa: float, fuente: string, actualizado: string, es_respaldo: bool}
     */
    public function informacion(): array
    {
        $tasaOficial = Configuracion::where('clave', self::OFFICIAL_KEY)->first();

        return [
            'tasa' => $this->bolivianosPorDolar(),
            'fuente' => $this->fuente(),
            'actualizado' => $tasaOficial?->updated_at?->toIso8601String() ?: now()->toIso8601String(),
            'es_respaldo' => $tasaOficial === null && $this->fuente() === 'OFICIAL',
        ];
    }

    public function actualizarOficialAhora(): ?float
    {
        $tasa = $this->consultarBancoCentral();

        if ($tasa === null) {
            return null;
        }

        $tasa = $this->guardarTasaOficial($tasa);
        Cache::put('finora.tipo-cambio.usd-bob.oficial', $tasa, now()->endOfDay()->addMinutes(5));

        return $tasa;
    }

    public function actualizarFuente(string $fuente, ?float $tasaManual = null): void
    {
        Configuracion::updateOrCreate(
            ['clave' => self::MODE_KEY],
            ['valor' => $fuente, 'descripcion' => 'Fuente activa del tipo de cambio.'],
        );

        if ($tasaManual !== null) {
            Configuracion::updateOrCreate(
                ['clave' => self::MANUAL_KEY],
                ['valor' => number_format($tasaManual, 6, '.', ''), 'descripcion' => 'Tipo de cambio manual USD a BOB.'],
            );
        }

        Cache::forget('finora.tipo-cambio.usd-bob.oficial');
    }

    private function guardarTasaOficial(?float $tasa): float
    {
        if ($tasa === null) {
            return (float) (Configuracion::where('clave', self::OFFICIAL_KEY)->value('valor') ?: config('finora.usd_to_bob_fallback', 12.00));
        }

        Configuracion::updateOrCreate(
            ['clave' => self::OFFICIAL_KEY],
            ['valor' => number_format($tasa, 6, '.', ''), 'descripcion' => 'Última tasa oficial obtenida del BCB.'],
        );

        return $tasa;
    }

    public function fuente(): string
    {
        return Configuracion::where('clave', self::MODE_KEY)->value('valor') ?: 'OFICIAL';
    }

    public function manual(): ?float
    {
        $valor = Configuracion::where('clave', self::MANUAL_KEY)->value('valor');

        return $valor !== null ? (float) $valor : null;
    }

    private function consultarBancoCentral(): ?float
    {
        try {
            $request = Http::accept('text/html')
                ->connectTimeout(3)
                ->retry(2, 250)
                ->timeout(5);

            if (! config('finora.exchange_rate_verify_ssl', false)) {
                $request = $request->withoutVerifying();
            }

            $response = $request->get(config('finora.exchange_rate_url'));

            if (! $response->successful()) {
                return null;
            }

            $textoPlano = preg_replace('/<[^>]+>/', ' ', $response->body()) ?? '';
            $contenido = preg_replace('/\s+/', ' ', html_entity_decode($textoPlano)) ?? '';

            if (preg_match('/ESTADOS\s+UNIDOS.*?\bUSD\b.*?(\d{1,3}(?:[\.,]\d{1,6})?)/i', $contenido, $matches) !== 1) {
                return null;
            }

            $tasa = (float) str_replace(',', '.', $matches[1]);

            return $tasa > 0 ? $tasa : null;
        } catch (\Throwable) {
            return null;
        }
    }
}
