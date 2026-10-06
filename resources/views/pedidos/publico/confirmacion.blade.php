<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedido recibido - Finora</title>
    <link rel="icon" type="image/png" href="{{ asset('images/branding/finora-icono.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#F4F7FB] text-slate-800 antialiased dark:bg-slate-950 dark:text-slate-100">
    @include('partials.header')
    <main class="mx-auto flex max-w-2xl px-4 pb-12 pt-32 sm:px-6">
        <section class="w-full rounded-3xl border border-slate-200 bg-white p-7 text-center shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-10">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                <span class="material-symbols-outlined text-4xl">check_circle</span>
            </div>
            <p class="mt-5 text-xs font-bold uppercase tracking-wider text-emerald-600">Solicitud registrada</p>
            <h1 class="mt-2 text-3xl font-extrabold text-slate-900 dark:text-white">Pedido #{{ $pedido->id }}</h1>
            <p class="mt-3 text-sm leading-relaxed text-slate-500 dark:text-slate-300">Recibimos tu solicitud. El consultor revisará disponibilidad y coordinará contigo el pago y la entrega.</p>
            <div class="mt-6 rounded-2xl bg-slate-50 p-4 text-left dark:bg-slate-800">
                @foreach ($pedido->detalles as $detalle)
                    <div class="flex justify-between gap-3 border-b border-slate-200 py-2 text-sm last:border-0 dark:border-slate-700">
                        <span>{{ $detalle->cantidad }} × {{ $detalle->producto->nombre }}</span>
                        <strong>@money($detalle->subtotal)</strong>
                    </div>
                @endforeach
                <div class="mt-2 flex justify-between border-t border-slate-300 pt-3 font-extrabold dark:border-slate-600"><span>Total estimado</span><span>@money($pedido->total)</span></div>
            </div>
            @if ($whatsappUrl)
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-extrabold text-white hover:bg-emerald-700">
                    <span class="material-symbols-outlined">chat</span> Continuar por WhatsApp
                </a>
            @else
                <p class="mt-6 rounded-xl bg-amber-50 p-3 text-xs text-amber-800">El pedido fue registrado. El número de WhatsApp del negocio aún no está configurado.</p>
            @endif
            <a href="{{ route('categorias') }}" class="mt-4 inline-block text-sm font-bold text-blue-600 hover:text-blue-800">Volver al catálogo</a>
        </section>
    </main>
    <script>
        window.localStorage.removeItem('finora-carrito');
        window.dispatchEvent(new Event('storage'));
    </script>
</body>
</html>
