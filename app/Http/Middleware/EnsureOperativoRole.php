<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOperativoRole
{
    /**
     * Verifica que el usuario autenticado posea el rol de CONSULTOR o COLABORADOR.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! in_array($request->user()->rol, ['CONSULTOR', 'COLABORADOR'])) {
            abort(403, 'Acceso no autorizado al panel de administración.');
        }

        return $next($request);
    }
}
