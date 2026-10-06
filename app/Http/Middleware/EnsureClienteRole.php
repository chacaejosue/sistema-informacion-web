<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClienteRole
{
    /**
     * Verifica que el usuario autenticado posea el rol de CLIENTE.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->rol !== 'CLIENTE') {
            abort(403, 'Acceso no autorizado al portal del cliente.');
        }

        return $next($request);
    }
}
