<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->restrictOnDelete();
            $table->foreignId('registrado_por_usuario_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->decimal('monto', 12, 2);
            $table->timestamp('fecha')->useCurrent();
            // EFECTIVO, TRANSFERENCIA, QR, TARJETA, OTRO, etc.
            $table->string('metodo', 40)->index();
            // REGISTRADO o ANULADO.
            $table->string('estado', 30)->default('REGISTRADO')->index();
            $table->text('observacion')->nullable();
            $table->timestamps();

            $table->index(['venta_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
