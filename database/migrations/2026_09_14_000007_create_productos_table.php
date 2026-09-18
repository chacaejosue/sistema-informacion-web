<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->restrictOnDelete();
            $table->foreignId('linea_id')->nullable()->constrained('lineas')->nullOnDelete();
            $table->foreignId('categoria_id')->constrained('categorias')->restrictOnDelete();
            $table->string('codigo', 80)->unique();
            $table->string('nombre', 180);
            $table->text('descripcion')->nullable();
            $table->decimal('precio_venta_actual', 12, 2);
            $table->string('imagen_principal', 255)->nullable();
            $table->boolean('publicado')->default(false)->index();
            $table->boolean('activo')->default(true)->index();
            $table->timestamps();

            $table->index(['categoria_id', 'activo']);
            $table->index(['linea_id', 'activo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
