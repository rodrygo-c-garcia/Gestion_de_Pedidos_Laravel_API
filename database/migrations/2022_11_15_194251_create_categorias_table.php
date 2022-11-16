<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            // por defecto
            $table->id(); // id
            $table->string("nombre", 30); // obligatorio
            $table->text("detalle")->nullable(); // no es obligatorio
            $table->timestamps();  // create_at, cupdate_at
        });
    }


    public function down()
    {
        Schema::dropIfExists('categorias');
    }
};
