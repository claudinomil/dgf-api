<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoConfiguracoesTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_configuracoes', function (Blueprint $table) {
            $table->id();
            $table->string('referencia');
            $table->date('data_vencimento')->nullable();

            //Diretor Geral de Finanças
            $table->string('diretor_identidade_funcional')->nullable();
            $table->string('diretor_rg')->nullable();
            $table->string('diretor_nome')->nullable();
            $table->string('diretor_posto')->nullable();
            $table->string('diretor_quadro')->nullable();
            $table->string('diretor_cargo')->default('Diretor Geral de Finanças');

            //Chefe da DGF/2 - Contabilidade
            $table->string('dgf2_identidade_funcional')->nullable();
            $table->string('dgf2_rg')->nullable();
            $table->string('dgf2_nome')->nullable();
            $table->string('dgf2_posto')->nullable();
            $table->string('dgf2_quadro')->nullable();
            $table->string('dgf2_cargo')->default('Chefe da DGF/2 - Contabilidade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_configuracoes');
    }
}
