<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('relatorios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modulo_id')->constrained('modulos');
            $table->string('name');
            $table->string('descricao');
            $table->integer('ordem_visualizacao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('relatorios');
    }
};
