<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Finora - Gestión de Líneas Comercial | Panel del Consultor</title>

    <link rel="icon" type="image/png" href="{{ asset('images/branding/finora-icono.png') }}"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&amp;family=Outfit:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans bg-finora-surface text-finora-navy antialiased selection:bg-finora-cyan selection:text-finora-navy flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
            <a class="inline-flex items-center gap-3.5 group" href="{{ route('panel.productos.index') }}">
                <div class="relative w-10 h-10 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora" class="h-9 w-auto object-contain group-hover:scale-105 transition-transform"/>
                </div>
                <div class="flex flex-col">
                    <span class="font-heading text-xl font-extrabold tracking-tight text-finora-navy">Finora</span>
                    <span class="text-[10px] font-medium text-finora-subtle -mt-1 tracking-wide">Líneas Comerciales</span>
                </div>
            </a>

            <a href="{{ route('panel.productos.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-finora-blue hover:text-finora-deepBlue">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Volver a Productos
            </a>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if (session('exito'))
            <div role="alert" class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 flex items-center justify-between text-emerald-800 text-sm font-medium">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                    <span>{{ session('exito') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulario de Alta -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm h-fit">
                <h2 class="font-heading text-lg font-bold text-finora-navy mb-4">Registrar Línea Comercial</h2>

                <form action="{{ route('panel.lineas.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="nombre" class="block text-xs font-bold text-finora-navy mb-1">Nombre de la Línea *</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej. Chronos" class="w-full bg-[#F8FAFC] border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-finora-navy focus:bg-white focus:ring-2 focus:ring-finora-blue outline-none">
                    </div>

                    <div>
                        <label for="descripcion" class="block text-xs font-bold text-finora-navy mb-1">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3" placeholder="Descripción de la línea..." class="w-full bg-[#F8FAFC] border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-finora-navy focus:bg-white focus:ring-2 focus:ring-finora-blue outline-none">{{ old('descripcion') }}</textarea>
                    </div>

                    <button type="submit" class="finora-gradient-btn w-full py-2.5 rounded-xl text-white font-heading font-semibold text-xs shadow-finora-btn cursor-pointer">
                        Guardar Línea
                    </button>
                </form>
            </div>

            <!-- Tabla de Líneas -->
            <div class="lg:col-span-2 bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-sm">
                <div class="p-4 bg-[#F8FAFC] border-b border-slate-200 flex items-center justify-between">
                    <h2 class="font-heading text-sm font-bold text-finora-navy">Líneas Registradas</h2>
                    <span class="text-xs text-finora-subtle font-medium">{{ $lineas->total() }} registros</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-[#F8FAFC] border-b border-slate-200 text-finora-subtle uppercase tracking-wider font-bold">
                            <tr>
                                <th class="py-3 px-4">Nombre</th>
                                <th class="py-3 px-4">Descripción</th>
                                <th class="py-3 px-4 text-center">Productos</th>
                                <th class="py-3 px-4 text-center">Estado</th>
                                <th class="py-3 px-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-finora-navy">
                            @forelse ($lineas as $lin)
                                <tr>
                                    <td class="py-3 px-4 font-bold text-finora-navy">
                                        {{ $lin->nombre }}
                                    </td>
                                    <td class="py-3 px-4 text-slate-600">
                                        {{ $lin->descripcion ?: '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-center font-bold">
                                        {{ $lin->productos_count }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $lin->activo ? 'bg-emerald-50 text-emerald-800' : 'bg-red-50 text-red-700' }}">
                                            {{ $lin->activo ? 'Activa' : 'Inactiva' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <form action="{{ route('panel.lineas.destroy', $lin) }}" method="POST" class="inline" onsubmit="return confirm('¿Desactivar línea?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-slate-400 hover:text-red-600 rounded cursor-pointer" title="Desactivar">
                                                <span class="material-symbols-outlined text-base">power_settings_new</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-finora-subtle">No hay líneas comerciales registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($lineas->hasPages())
                    <div class="p-3 border-t border-slate-200">
                        {{ $lineas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>

</body>
</html>
