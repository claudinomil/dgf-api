<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grupos_relatorios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupos');
            $table->foreignId('relatorio_id')->constrained('relatorios');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grupos_relatorios');
    }
};
