<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureConsultorRole
{
    /**
     * Verifica que el usuario autenticado posea el rol de CONSULTOR.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->rol !== 'CONSULTOR') {
            abort(403, 'Acceso no autorizado al panel del consultor.');
        }

        return $next($request);
    }
}
