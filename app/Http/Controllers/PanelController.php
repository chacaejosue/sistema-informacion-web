<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
{
    /**
     * Muestra el panel principal del consultor.
     */
    public function index()
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('persona');

        return view('panel', [
            'usuario' => $usuario,
        ]);
    }
}
