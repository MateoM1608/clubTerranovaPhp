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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id()->unsigned()->primary();
            $table->text('producto')->nullable();
            $table->float('precio_unitario')->nullable();
            $table->float('cantidad')->nullable();
            $table->float('precio_total')->nullable();
            $table->date('fecha')->nullable();
            $table->text('usuario')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
