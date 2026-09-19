<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credito_id')->constrained('creditos')->cascadeOnDelete();
            $table->unsignedSmallInteger('numero');
            $table->decimal('monto', 12, 2);
            $table->date('fecha_vencimiento');
            // PENDIENTE, PARCIAL, VENCIDA, PAGADA.
            $table->string('estado', 30)->default('PENDIENTE')->index();
            $table->timestamps();

            $table->unique(['credito_id', 'numero']);
            $table->index(['estado', 'fecha_vencimiento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuotas');
    }
};
