<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutsModesTable extends Migration
{
    public function up()
    {
        Schema::create('layouts_modes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descricao');
            $table->integer('ativo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layouts_modes');
    }
}
