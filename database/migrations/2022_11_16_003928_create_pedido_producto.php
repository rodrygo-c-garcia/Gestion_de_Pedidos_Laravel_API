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
        Schema::create('pedido_producto', function (Blueprint $table) {
            $table->id();
            // N:M
            $table->bigInteger("pedido_id")->unsigned();
            $table->bigInteger("producto_id")->unsigned();

            $table->foreign("pedido_id")->references("id")->on("pedidos");
            $table->foreign("producto_id")->references("id")->on("productos");

            $table->integer("cantidad")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido_producto');
    }
};
