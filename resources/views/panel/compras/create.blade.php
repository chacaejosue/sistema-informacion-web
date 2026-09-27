<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Finora - Crear Compra | Panel del Consultor</title>
    <link rel="icon" type="image/png" href="{{ asset('images/branding/finora-icono.png') }}"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&amp;family=Outfit:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans bg-finora-surface text-finora-navy antialiased selection:bg-finora-cyan selection:text-finora-navy flex flex-col min-h-screen">

    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
            <a class="inline-flex items-center gap-3.5 group" href="{{ route('panel.index') }}">
                <div class="relative w-10 h-10 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/branding/finora-isotipo.png') }}" alt="Finora" class="h-9 w-auto object-contain group-hover:scale-105 transition-transform"/>
                </div>
                <div class="flex flex-col">
                    <span class="font-heading text-xl font-extrabold tracking-tight text-finora-navy">Finora</span>
                    <span class="text-[10px] font-medium text-finora-subtle -mt-1 tracking-wide">Nueva Compra</span>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('panel.compras.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-finora-blue hover:text-finora-deepBlue">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Volver a compras
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 sm:p-8 shadow-sm">
            <h1 class="font-heading text-xl font-extrabold text-finora-navy mb-6">Registrar Orden de Compra (Borrador)</h1>

            <form action="{{ route('panel.compras.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="proveedor_id" class="block text-xs font-bold text-finora-navy mb-1">Proveedor *</label>
                    <select id="proveedor_id" name="proveedor_id" required class="w-full bg-[#F8FAFC] border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-finora-navy focus:bg-white focus:ring-2 focus:ring-finora-blue outline-none">
                        <option value="">-- Seleccionar Proveedor --</option>
                        @foreach ($proveedores as $prov)
                            <option value="{{ $prov->id }}" {{ old('proveedor_id') == $prov->id ? 'selected' : '' }}>{{ $prov->nombre }}</option>
                        @endforeach
                    </select>
                    @error('proveedor_id') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="border-t border-b border-slate-100 py-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="font-heading font-bold text-sm text-finora-navy">Detalle de Productos</h3>
                        <button type="button" id="btn-add-item" class="px-3 py-1.5 bg-blue-50 text-finora-blue hover:bg-blue-100 rounded-xl text-xs font-bold inline-flex items-center gap-1 transition-colors">
                            <span class="material-symbols-outlined text-sm">add</span>
                            Agregar Producto
                        </button>
                    </div>

                    <div id="items-container" class="space-y-3">
                        <div class="item-row grid grid-cols-1 sm:grid-cols-12 gap-2 items-center bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <div class="sm:col-span-6">
                                <label class="block text-[10px] font-bold text-finora-subtle mb-1">Producto</label>
                                <select name="detalles[0][producto_id]" required class="w-full bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-finora-navy outline-none">
                                    <option value="">-- Seleccionar Producto --</option>
                                    @foreach ($productos as $prod)
                                        <option value="{{ $prod->id }}">{{ $prod->codigo }} - {{ $prod->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[10px] font-bold text-finora-subtle mb-1">Cantidad</label>
                                <input type="number" min="1" name="detalles[0][cantidad]" value="1" required class="w-full bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-finora-navy outline-none">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[10px] font-bold text-finora-subtle mb-1">Costo Unitario ($)</label>
                                <input type="number" step="0.01" min="0" name="detalles[0][costo_unitario]" value="0.00" required class="w-full bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-finora-navy outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="observaciones" class="block text-xs font-bold text-finora-navy mb-1">Observaciones / Notas</label>
                    <textarea id="observaciones" name="observaciones" rows="2" class="w-full bg-[#F8FAFC] border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-finora-navy focus:bg-white focus:ring-2 focus:ring-finora-blue outline-none" placeholder="Instrucciones de entrega, número de pedido externo, etc.">{{ old('observaciones') }}</textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('panel.compras.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="finora-gradient-btn px-5 py-2 rounded-xl text-white font-heading font-semibold text-xs shadow-finora-btn">
                        Guardar Compra en Borrador
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let itemIdx = 1;
            const container = document.getElementById('items-container');
            const btnAdd = document.getElementById('btn-add-item');

            const productsOptions = `@foreach ($productos as $prod)<option value="{{ $prod->id }}">{{ $prod->codigo }} - {{ $prod->nombre }}</option>@endforeach`;

            btnAdd.addEventListener('click', () => {
                const div = document.createElement('div');
                div.className = 'item-row grid grid-cols-1 sm:grid-cols-12 gap-2 items-center bg-slate-50 p-3 rounded-xl border border-slate-200 relative';
                div.innerHTML = `
                    <div class="sm:col-span-5">
                        <label class="block text-[10px] font-bold text-finora-subtle mb-1">Producto</label>
                        <select name="detalles[${itemIdx}][producto_id]" required class="w-full bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-finora-navy outline-none">
                            <option value="">-- Seleccionar Producto --</option>
                            ${productsOptions}
                        </select>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-[10px] font-bold text-finora-subtle mb-1">Cantidad</label>
                        <input type="number" min="1" name="detalles[${itemIdx}][cantidad]" value="1" required class="w-full bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-finora-navy outline-none">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-[10px] font-bold text-finora-subtle mb-1">Costo Unitario ($)</label>
                        <input type="number" step="0.01" min="0" name="detalles[${itemIdx}][costo_unitario]" value="0.00" required class="w-full bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs text-finora-navy outline-none">
                    </div>
                    <div class="sm:col-span-1 text-right pt-3 sm:pt-0">
                        <button type="button" class="btn-remove-row text-red-500 hover:text-red-700 p-1" title="Eliminar fila">
                            <span class="material-symbols-outlined text-base">delete</span>
                        </button>
                    </div>
                `;
                container.appendChild(div);
                itemIdx++;

                div.querySelector('.btn-remove-row').addEventListener('click', () => {
                    div.remove();
                });
            });
        });
    </script>
</body>
</html>
