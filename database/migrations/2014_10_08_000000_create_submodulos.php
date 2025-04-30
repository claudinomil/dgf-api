<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('submodulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modulo_id')->constrained('modulos');
            $table->string('name');
            $table->string('menu_text');
            $table->string('menu_url')->unique();
            $table->string('menu_route')->unique();
            $table->string('menu_icon');
            $table->string('prefix_permissao')->unique();
            $table->string('prefix_route')->unique();
            $table->string('descricao')->nullable();
            $table->integer('ordem_visualizacao');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('submodulos');
    }
};
