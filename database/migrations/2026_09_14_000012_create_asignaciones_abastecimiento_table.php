<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignaciones_abastecimiento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detalle_compra_id')->constrained('detalle_compras')->cascadeOnDelete();
            $table->foreignId('detalle_pedido_id')->constrained('detalle_pedidos')->cascadeOnDelete();
            $table->unsignedInteger('cantidad');
            $table->timestamps();

            $table->unique(['detalle_compra_id', 'detalle_pedido_id'], 'asig_compra_pedido_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones_abastecimiento');
    }
};
