<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarTipoCambioRequest;
use App\Services\TipoCambioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class TipoCambioController extends Controller
{
    public function __invoke(TipoCambioService $tipoCambio): JsonResponse
    {
        $informacion = $tipoCambio->informacion();

        return response()->json([
            'base' => 'BOB',
            'destino' => 'USD',
            'bolivianos_por_dolar' => $informacion['tasa'],
            'fuente' => $informacion['fuente'],
            'actualizado' => $informacion['actualizado'],
        ]);
    }

    public function update(ActualizarTipoCambioRequest $request, TipoCambioService $tipoCambio): RedirectResponse
    {
        $datos = $request->validated();
        $tipoCambio->actualizarFuente($datos['fuente'], isset($datos['tasa_manual']) ? (float) $datos['tasa_manual'] : null);

        return back()->with('exito', 'Configuración del tipo de cambio actualizada.');
    }

    public function refresh(TipoCambioService $tipoCambio): RedirectResponse
    {
        if ($tipoCambio->actualizarOficialAhora() === null) {
            return back()->withErrors(['tipo_cambio' => 'No se pudo consultar el BCB en este momento. Se conserva la última tasa disponible.']);
        }

        return back()->with('exito', 'Tipo de cambio oficial actualizado ahora mismo.');
    }
}
