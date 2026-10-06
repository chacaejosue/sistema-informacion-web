<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Solicitar pedido - Finora</title>
    <link rel="icon" type="image/png" href="{{ asset('images/branding/finora-icono.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#F4F7FB] text-slate-800 antialiased dark:bg-slate-950 dark:text-slate-100">
    @include('partials.header')

    <main class="mx-auto max-w-7xl px-4 pb-12 pt-28 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-blue-600">Pedido por catálogo</p>
                <h1 class="mt-1 text-3xl font-extrabold text-slate-900 dark:text-white">Arma tu pedido</h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Selecciona tus productos y completa solo tu nombre y teléfono para coordinar por WhatsApp.</p>
            </div>
            <a href="{{ route('categorias') }}" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-800">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Volver al catálogo
            </a>
        </div>

        @if ($errors->any())
            <div role="alert" class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="mx-auto max-w-2xl">
            <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-7" aria-labelledby="pedido-title">
                <div class="flex items-center justify-between gap-3">
                    <h2 id="pedido-title" class="text-lg font-extrabold text-slate-900 dark:text-white">Tu solicitud</h2>
                    <span id="cartCount" class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 dark:bg-blue-950 dark:text-blue-200">0 productos</span>
                </div>
                <div id="cartItems" class="mt-4 space-y-3"></div>
                <div id="cartEmpty" class="mt-4 rounded-xl bg-slate-50 p-4 text-center text-sm text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                    <p>Todavía no agregaste productos.</p>
                    <a href="{{ route('categorias') }}" class="mt-3 inline-flex items-center gap-2 font-bold text-blue-600 hover:text-blue-800"><span class="material-symbols-outlined text-base">arrow_back</span> Volver al catálogo</a>
                </div>

                <form id="publicOrderForm" action="{{ route('carrito.pedido') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div class="grid gap-3 sm:grid-cols-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-200">Nombre *
                            <input name="nombre" autocomplete="given-name" maxlength="100" value="{{ old('nombre') }}" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        </label>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-200">Apellido <span class="font-normal text-slate-400">(opcional)</span>
                            <input name="apellido" autocomplete="family-name" maxlength="100" value="{{ old('apellido') }}" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        </label>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-200">Teléfono *
                            <input type="tel" name="telefono" autocomplete="tel" inputmode="tel" maxlength="30" value="{{ old('telefono') }}" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        </label>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-200">Correo <span class="font-normal text-slate-400">(opcional)</span>
                            <input type="email" name="email" autocomplete="email" maxlength="255" value="{{ old('email') }}" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        </label>
                    </div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-200">Dirección o referencia <span class="font-normal text-slate-400">(opcional)</span>
                        <input name="direccion" autocomplete="street-address" maxlength="255" value="{{ old('direccion') }}" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                    </label>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-200">Preferencia de pago *
                        <select name="preferencia_pago" required class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                            <option value="" disabled {{ old('preferencia_pago') ? '' : 'selected' }}>Selecciona una forma de pago</option>
                            <option value="POR_CONFIRMAR" {{ old('preferencia_pago') === 'POR_CONFIRMAR' ? 'selected' : '' }}>Quiero coordinarlo con el consultor</option>
                            <option value="CONTADO" {{ old('preferencia_pago') === 'CONTADO' ? 'selected' : '' }}>Contado</option>
                            <option value="CREDITO" {{ old('preferencia_pago') === 'CREDITO' ? 'selected' : '' }}>Solicitar compra a crédito</option>
                        </select>
                    </label>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-200">Observaciones <span class="font-normal text-slate-400">(opcional)</span>
                        <textarea name="observaciones" rows="3" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">{{ old('observaciones') }}</textarea>
                    </label>
                    <div id="cartPayload"></div>
                    <button id="submitOrder" type="submit" disabled class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:bg-slate-300">
                        Enviar solicitud y continuar por WhatsApp
                    </button>
                    <p class="text-center text-[11px] text-slate-500 dark:text-slate-400">El pedido queda pendiente de confirmación. No se realiza ningún cobro en línea.</p>
                </form>
            </section>
        </div>
    </main>

    @php
        $productosParaCarrito = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => (float) $producto->precio_venta_actual,
            ];
        })->values();
    @endphp
    <script>
        window.finoraProducts = @json($productosParaCarrito);

        document.addEventListener('DOMContentLoaded', () => {
            const products = new Map(window.finoraProducts.map(product => [String(product.id), product]));
            const storageKey = 'finora-carrito';
            let cart = JSON.parse(window.localStorage.getItem(storageKey) || '[]').filter(item => products.has(String(item.id)));
            const items = document.getElementById('cartItems');
            const empty = document.getElementById('cartEmpty');
            const count = document.getElementById('cartCount');
             const payload = document.getElementById('cartPayload');
             const submit = document.getElementById('submitOrder');
             let displayCurrency = 'BOB';
             let exchangeRate = 12;

            function escapeHtml(value) {
                return String(value).replace(/[&<>"']/g, character => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;',
                }[character]));
            }

            function save() {
                window.localStorage.setItem(storageKey, JSON.stringify(cart));
            }

            function render() {
                items.innerHTML = '';
                let totalItems = 0;
                let total = 0;
                cart.forEach((item, index) => {
                    const product = products.get(String(item.id));
                    totalItems += item.qty;
                    total += product.precio * item.qty;
                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-3 rounded-xl bg-slate-50 p-3 dark:bg-slate-800';
                     row.innerHTML = `<div class="min-w-0 flex-1"><p class="truncate text-xs font-bold text-slate-800 dark:text-slate-100">${escapeHtml(product.nombre)}</p><p class="mt-1 text-xs text-slate-500 dark:text-slate-400">${formatMoney(product.precio * item.qty)}</p></div><div class="flex items-center gap-2"><button type="button" data-minus="${index}" class="h-7 w-7 rounded-lg bg-white text-sm font-bold shadow-sm dark:bg-slate-700 dark:text-white">−</button><span class="w-5 text-center text-xs font-bold dark:text-slate-100">${item.qty}</span><button type="button" data-plus="${index}" class="h-7 w-7 rounded-lg bg-white text-sm font-bold shadow-sm dark:bg-slate-700 dark:text-white">+</button><button type="button" data-remove="${index}" class="ml-1 text-red-500" aria-label="Quitar producto"><span class="material-symbols-outlined text-lg">delete</span></button></div>`;
                    items.appendChild(row);
                });
                if (cart.length) {
                    const totalRow = document.createElement('div');
                    totalRow.className = 'flex justify-between border-t border-slate-200 pt-3 text-sm font-extrabold text-slate-900 dark:border-slate-700 dark:text-white';
                     totalRow.innerHTML = `<span>Total estimado</span><span>${formatMoney(total)}</span>`;
                    items.appendChild(totalRow);
                }
                count.textContent = `${totalItems} producto${totalItems === 1 ? '' : 's'}`;
                empty.classList.toggle('hidden', cart.length > 0);
                submit.disabled = cart.length === 0;
                payload.innerHTML = cart.map((item, index) => `<input type="hidden" name="carrito[${index}][producto_id]" value="${Number(item.id)}"><input type="hidden" name="carrito[${index}][cantidad]" value="${item.qty}">`).join('');
                save();
            }

             function formatMoney(value) {
                 if (displayCurrency === 'USD') {
                     return `USD ${(Number(value) / exchangeRate).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                 }

                 return `Bs ${Number(value).toLocaleString('es-BO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
             }

             document.addEventListener('finora:currency-changed', event => {
                 displayCurrency = event.detail.currency;
                 exchangeRate = event.detail.rate;
                 render();
             });

             document.querySelectorAll('[data-add-product]').forEach(button => button.addEventListener('click', () => {
                const id = String(button.dataset.addProduct);
                const existing = cart.find(item => String(item.id) === id);
                if (existing) existing.qty = Math.min(existing.qty + 1, 99);
                else cart.push({ id, qty: 1 });
                 window.finoraShowAdded(button);
                 render();
            }));

            items.addEventListener('click', event => {
                const button = event.target.closest('button');
                if (!button) return;
                const index = Number(button.dataset.plus ?? button.dataset.minus ?? button.dataset.remove);
                if (button.dataset.plus !== undefined) cart[index].qty = Math.min(cart[index].qty + 1, 99);
                if (button.dataset.minus !== undefined) cart[index].qty -= 1;
                if (button.dataset.remove !== undefined || cart[index]?.qty <= 0) cart.splice(index, 1);
                render();
            });

            document.getElementById('publicOrderForm').addEventListener('submit', event => {
                if (!cart.length) event.preventDefault();
            });
            render();
        });
    </script>
</body>
</html>
