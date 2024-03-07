<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoCobrancasPdfsOficiosTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_cobrancas_pdfs_oficios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ressarcimento_orgao_id')->constrained('ressarcimento_orgaos', 'id', 'rcpo_orgao_id');

            $table->string('referencia')->nullable();
            $table->string('referencia_ano')->nullable();
            $table->string('referencia_mes')->nullable();
            $table->string('referencia_parte')->nullable();

            $table->integer('oficio_numero')->nullable();
            $table->integer('oficio_ano')->nullable();

            $table->string('orgao_name')->nullable();
            $table->string('orgao_cnpj')->nullable();
            $table->string('orgao_ug')->nullable();
            $table->string('orgao_destinatario_pequeno')->nullable();
            $table->string('orgao_destinatario_grande')->nullable();
            $table->string('orgao_responsavel')->nullable();
            $table->string('orgao_esfera')->nullable();
            $table->string('orgao_poder')->nullable();
            $table->string('orgao_tratamento_completo')->nullable();
            $table->string('orgao_tratamento_reduzido')->nullable();
            $table->string('orgao_vocativo')->nullable();
            $table->string('orgao_funcao')->nullable();
            $table->string('orgao_telefone_1')->nullable();
            $table->string('orgao_telefone_2')->nullable();
            $table->string('orgao_cep')->nullable();
            $table->string('orgao_numero')->nullable();
            $table->string('orgao_complemento')->nullable();
            $table->string('orgao_logradouro')->nullable();
            $table->string('orgao_bairro')->nullable();
            $table->string('orgao_localidade')->nullable();
            $table->string('orgao_uf')->nullable();
            $table->string('orgao_contato_nome')->nullable();
            $table->string('orgao_contato_telefone')->nullable();
            $table->string('orgao_contato_celular')->nullable();
            $table->string('orgao_contato_email')->nullable();

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
        Schema::dropIfExists('ressarcimento_cobrancas_pdfs_oficios');
    }
}
