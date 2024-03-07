<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoCobrancasPdfsNotasTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_cobrancas_pdfs_notas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ressarcimento_orgao_id')->constrained('ressarcimento_orgaos', 'id', 'rcpn_orgao_id');

            $table->string('referencia')->nullable();
            $table->string('referencia_ano')->nullable();
            $table->string('referencia_mes')->nullable();
            $table->string('referencia_parte')->nullable();

            $table->string('orgao_name')->nullable();

            $table->integer('oficio_numero')->nullable();
            $table->integer('oficio_ano')->nullable();

            $table->string('total_militares')->nullable();
            $table->string('valor_recursos_oriundos_fonte100')->nullable();
            $table->string('valor_recursos_oriundos_fonte232')->nullable();
            $table->string('valor_bruto_folha_suplementar')->nullable();
            $table->string('valor_rioprevidencia')->nullable();
            $table->string('valor_fundo_saude')->nullable();
            $table->string('valor_total')->nullable();

            $table->date('configuracao_data_vencimento')->nullable();
            $table->string('configuracao_diretor_identidade_funcional')->nullable();
            $table->string('configuracao_diretor_rg')->nullable();
            $table->string('configuracao_diretor_nome')->nullable();
            $table->string('configuracao_diretor_posto')->nullable();
            $table->string('configuracao_diretor_quadro')->nullable();
            $table->string('configuracao_diretor_cargo')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_cobrancas_pdfs_notas');
    }
}
