<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_producto', function (Blueprint $table) {
            $table->id();
            $table->foreingId('categoriaId')
                ->nullable()
                ->constrained('categorias')
                ->cascadeUpdate()
                ->nullOnDelete();

        $table->id();
        $table->foreingId('productoId')
            ->nullable()
            ->constrained('productos')
            ->cascadeUpdate()
            ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria_producto');
    }
};
