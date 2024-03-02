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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('codigo', 50);
            $table->decimal('precio_venta', 10, 2)->nullable();
            $table->string('descripcion', 255)->nullable();
            $table->string('marca', 255)->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('img_path', 255)->nullable();
            $table->tinyInteger('estado')->default(1);
            $table->decimal('stock', 10, 2)->unsigned()->default(0);
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
