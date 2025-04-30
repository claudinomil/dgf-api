<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSadMilitaresInformacoesTable extends Migration
{
    public function up()
    {
        Schema::create('sad_militares_informacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setor_id')->nullable()->constrained('setores');
            $table->foreignId('funcao_id')->nullable()->constrained('funcoes');
            $table->text('foto');

            //Militar de referência
            $table->string('militar_rg')->unique();
            $table->string('militar_nome')->nullable();
            $table->integer('militar_posto_graduacao_ordem')->nullable();
            $table->string('militar_posto_graduacao')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sad_militares_informacoes');
    }
}
