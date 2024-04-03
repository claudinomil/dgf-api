<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users_relatorios_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('relatorio_id')->constrained('relatorios');
            $table->integer('ordem_visualizacao')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_relatorios_views');
    }
};
