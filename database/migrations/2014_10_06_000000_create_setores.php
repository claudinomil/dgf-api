<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('setores', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('menu_icon');
            $table->integer('ordem_visualizacao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('setores');
    }
};
