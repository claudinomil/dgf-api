<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ferramentas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descricao');
            $table->string('url');
            $table->string('icon');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('ordem_visualizacao');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ferramentas');
    }
};
