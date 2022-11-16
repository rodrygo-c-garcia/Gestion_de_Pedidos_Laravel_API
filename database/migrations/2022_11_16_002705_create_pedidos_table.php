<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->dateTime("fecha_pedido");
            $table->string("cod_fatura");
            //1:N
            $table->bigInteger("cliente_id")->unsigned();
            $table->foreign("cliente_id")->references("id")->on("clientes");

            $table->bigInteger("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users");

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};
