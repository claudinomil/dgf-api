<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setor_id')->nullable()->constrained('setores');
            $table->string('name')->unique();
            $table->string('menu_text');
            $table->string('menu_url')->unique();
            $table->string('menu_route')->unique();
            $table->string('menu_icon');
            $table->integer('ordem_visualizacao');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('modulos');
    }
};
