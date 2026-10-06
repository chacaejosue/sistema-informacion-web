<?php

namespace App\Console\Commands;

use App\Services\TipoCambioService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('finora:actualizar-tipo-cambio')]
#[Description('Actualiza la tasa oficial USD/BOB desde el Banco Central de Bolivia')]
class ActualizarTipoCambioCommand extends Command
{
    public function handle(TipoCambioService $tipoCambio): int
    {
        $tasa = $tipoCambio->actualizarOficialAhora();

        if ($tasa === null) {
            $this->error('No se pudo actualizar la tasa oficial desde el BCB.');

            return self::FAILURE;
        }

        $this->info(sprintf('Tipo de cambio actualizado: %.4f Bs/USD.', $tasa));

        return self::SUCCESS;
    }
}
