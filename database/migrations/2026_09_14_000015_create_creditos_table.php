<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creditos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->unique()->constrained('ventas')->restrictOnDelete();
            $table->decimal('monto_financiado', 12, 2);
            $table->decimal('interes_porcentaje', 5, 2)->default(0);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            // ACTIVO, VENCIDO, PAGADO, ANULADO.
            $table->string('estado', 30)->default('ACTIVO')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creditos');
    }
};
