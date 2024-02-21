<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoMilitaresTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_militares', function (Blueprint $table) {
            $table->id();
            $table->string('referencia');
            $table->string('identidade_funcional')->nullable();
            $table->string('rg')->nullable();
            $table->string('nome')->nullable();
            $table->integer('oficial_praca')->nullable();
            $table->string('posto_graduacao')->nullable();
            $table->string('quadro_qbmp')->nullable();
            $table->string('boletim')->nullable();
            $table->integer('lotacao_id')->nullable();
            $table->string('lotacao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_militares');
    }
}
