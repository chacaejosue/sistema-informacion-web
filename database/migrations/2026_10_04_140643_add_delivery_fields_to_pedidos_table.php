<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->timestamp('fecha_entrega')->nullable()->after('fecha');
            $table->foreignId('entregado_por_usuario_id')->nullable()->after('fecha_entrega')->constrained('usuarios')->nullOnDelete();
            $table->string('recibido_por', 150)->nullable()->after('entregado_por_usuario_id');
            $table->text('observaciones_entrega')->nullable()->after('recibido_por');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['entregado_por_usuario_id']);
            $table->dropColumn([
                'fecha_entrega',
                'entregado_por_usuario_id',
                'recibido_por',
                'observaciones_entrega',
            ]);
        });
    }
};
