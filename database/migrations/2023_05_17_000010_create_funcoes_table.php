<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncoesTable extends Migration
{
    public function up()
    {
        Schema::create('funcoes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('ordem_visualizacao')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcoes');
    }
}
