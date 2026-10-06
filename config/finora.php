<?php

return [
    'currency_code' => 'BOB',
    'currency_symbol' => 'Bs',
    'exchange_rate_url' => env('FINORA_EXCHANGE_RATE_URL', 'https://www.bcb.gob.bo/librerias/indicadores/otras/ultimo.php'),
    'exchange_rate_verify_ssl' => env('FINORA_EXCHANGE_RATE_VERIFY_SSL', false),
    'exchange_rate_cache_minutes' => env('FINORA_EXCHANGE_RATE_CACHE_MINUTES', 1440),
    'usd_to_bob_fallback' => env('FINORA_USD_TO_BOB_FALLBACK', 12.00),
    'demo_consultor_email' => env('FINORA_DEMO_CONSULTOR_EMAIL', 'consultora.demo@finora.test'),
    'demo_colaborador_email' => env('FINORA_DEMO_COLABORADOR_EMAIL', 'colaborador.demo@finora.test'),
    'demo_cliente_email' => env('FINORA_DEMO_CLIENTE_EMAIL', 'ana.cliente@finora.test'),
    'demo_consultor_password' => env('FINORA_DEMO_CONSULTOR_PASSWORD', 'FinoraDemo2026!'),
    'demo_colaborador_password' => env('FINORA_DEMO_COLABORADOR_PASSWORD', 'FinoraDemo2026!'),
    'demo_cliente_password' => env('FINORA_DEMO_CLIENTE_PASSWORD', 'FinoraDemo2026!'),
];
