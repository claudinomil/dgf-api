<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoCobrancasPdfsListagensTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_cobrancas_pdfs_listagens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ressarcimento_orgao_id')->constrained('ressarcimento_orgaos', 'id', 'rcpl_orgao_id');

            $table->string('referencia')->nullable();
            $table->string('referencia_ano')->nullable();
            $table->string('referencia_mes')->nullable();
            $table->string('referencia_parte')->nullable();

            $table->string('orgao_name')->nullable();

            $table->string('configuracao_dgf2_identidade_funcional')->nullable();
            $table->string('configuracao_dgf2_rg')->nullable();
            $table->string('configuracao_dgf2_nome')->nullable();
            $table->string('configuracao_dgf2_posto')->nullable();
            $table->string('configuracao_dgf2_quadro')->nullable();
            $table->string('configuracao_dgf2_cargo')->nullable();

            $table->integer('nota_numero')->nullable();
            $table->integer('nota_ano')->nullable();
            $table->string('oe_cobrar')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_cobrancas_pdfs_listagens');
    }
}
