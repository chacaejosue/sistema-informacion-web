<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finora - Reportes</title>
    <link rel="icon" type="image/png" href="{{ asset('images/branding/finora-icono.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-finora-surface text-finora-navy antialiased dark:bg-slate-950 dark:text-slate-100">
    <header class="border-b border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-finora-blue">Panel comercial</p>
                <h1 class="text-2xl font-extrabold">Reportes</h1>
            </div>
            <a href="{{ route('panel.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-xs font-bold hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">
                <span class="material-symbols-outlined text-base">arrow_back</span> Volver al panel
            </a>
        </div>
    </header>
    @include('partials.panel-nav')

    <main class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('panel.reportes.index') }}" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:flex-row sm:items-end">
            <label class="text-xs font-bold text-slate-600 dark:text-slate-300">Desde
                <input type="date" name="desde" value="{{ $desde }}" class="mt-1 block rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            </label>
            <label class="text-xs font-bold text-slate-600 dark:text-slate-300">Hasta
                <input type="date" name="hasta" value="{{ $hasta }}" class="mt-1 block rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            </label>
            <button class="rounded-xl bg-finora-navy px-4 py-2.5 text-xs font-bold text-white hover:bg-finora-dark">Actualizar</button>
            <a href="{{ route('panel.reportes.exportar', ['desde' => $desde, 'hasta' => $hasta]) }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-center text-xs font-bold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Exportar CSV</a>
        </form>

        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['label' => 'Ventas confirmadas', 'value' => \App\Support\Money::format($totalVentas), 'icon' => 'point_of_sale', 'iconClass' => 'text-blue-600 dark:text-blue-300'],
                ['label' => 'Cobrado', 'value' => \App\Support\Money::format($totalCobrado), 'icon' => 'payments', 'iconClass' => 'text-emerald-600 dark:text-emerald-300'],
                ['label' => 'Pedidos pendientes', 'value' => $pedidosPendientes, 'icon' => 'shopping_cart', 'iconClass' => 'text-purple-600 dark:text-purple-300'],
                ['label' => 'Clientes con saldo', 'value' => $clientesConSaldo, 'icon' => 'account_balance', 'iconClass' => 'text-amber-600 dark:text-amber-300'],
            ] as $card)
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                    <span class="material-symbols-outlined {{ $card['iconClass'] }}">{{ $card['icon'] }}</span>
                    <p class="mt-4 text-xs font-bold text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                    <p class="mt-1 text-2xl font-extrabold text-finora-navy dark:text-white">{{ $card['value'] }}</p>
                </article>
            @endforeach
        </section>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="flex items-center justify-between gap-3"><h2 class="font-extrabold">Productos más vendidos</h2><span class="text-xs text-slate-500 dark:text-slate-400">{{ $ventasContado }} contado · {{ $ventasCredito }} crédito</span></div>
                <div class="mt-4 divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($productosMasVendidos as $producto)
                        <div class="flex items-center justify-between gap-3 py-3 text-sm"><span class="truncate">{{ $producto->nombre }}</span><span class="shrink-0 font-bold">{{ $producto->unidades }} u. · @money($producto->importe)</span></div>
                    @empty
                        <p class="py-4 text-sm text-slate-500 dark:text-slate-400">No hay ventas confirmadas en este periodo.</p>
                    @endforelse
                </div>
            </section>
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <h2 class="font-extrabold">Stock bajo</h2>
                <div class="mt-4 divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($stockBajo as $producto)
                        <div class="flex items-center justify-between gap-3 py-3 text-sm"><span class="truncate">{{ $producto->nombre }}</span><span class="shrink-0 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">{{ $producto->movimientos_inventario_sum_cantidad ?? 0 }} u.</span></div>
                    @empty
                        <p class="py-4 text-sm text-slate-500 dark:text-slate-400">No hay productos con stock bajo.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div class="border-b border-slate-100 p-5 dark:border-slate-800"><h2 class="font-extrabold">Ventas del periodo</h2></div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-800 dark:text-slate-300"><tr><th class="px-5 py-3">Venta</th><th class="px-5 py-3">Fecha</th><th class="px-5 py-3">Cliente</th><th class="px-5 py-3">Pago</th><th class="px-5 py-3 text-right">Total</th><th class="px-5 py-3 text-right">Saldo</th></tr></thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($ventas as $venta)
                            <tr><td class="px-5 py-3 font-bold">#{{ $venta->id }}</td><td class="px-5 py-3">{{ $venta->fecha?->format('d/m/Y') }}</td><td class="px-5 py-3">{{ $venta->cliente?->persona?->nombre ?? '—' }}</td><td class="px-5 py-3">{{ $venta->forma_pago }}</td><td class="px-5 py-3 text-right font-bold">@money($venta->total)</td><td class="px-5 py-3 text-right">@money($venta->saldo_pendiente)</td></tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-8 text-center text-slate-500 dark:text-slate-400">No hay ventas para mostrar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
