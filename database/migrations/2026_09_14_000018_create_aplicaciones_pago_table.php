<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aplicaciones_pago', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_id')->constrained('pagos')->cascadeOnDelete();
            $table->foreignId('cuota_id')->constrained('cuotas')->restrictOnDelete();
            $table->decimal('monto_aplicado', 12, 2);
            $table->timestamps();

            $table->unique(['pago_id', 'cuota_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aplicaciones_pago');
    }
};
