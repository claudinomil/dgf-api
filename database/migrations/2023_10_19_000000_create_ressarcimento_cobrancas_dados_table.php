<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoCobrancasDadosTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_cobrancas_dados', function (Blueprint $table) {
            $table->id();

            //Campos de referência em outras tabelas
            $table->foreignId('ressarcimento_referencia_id')->constrained('ressarcimento_referencias', 'id', 'rcd_referencia_id');
            $table->foreignId('ressarcimento_orgao_id')->constrained('ressarcimento_orgaos', 'id', 'rcd_orgao_id');
            $table->foreignId('ressarcimento_militar_id')->constrained('ressarcimento_militares', 'id', 'rcd_militar_id');
            $table->foreignId('ressarcimento_pagamento_id')->constrained('ressarcimento_pagamentos', 'id', 'rcd_pagamento_id');

            //Dados da Referência (ressarcimento_referencias)
            $table->string('referencia')->nullable();
            $table->string('referencia_ano')->nullable();
            $table->string('referencia_mes')->nullable();
            $table->string('referencia_parte')->nullable();

            //Dados do Órgão (ressarcimento_orgaos)
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

            //Dados do Militar (ressarcimento_militares)
            $table->string('militar_identidade_funcional')->nullable();
            $table->string('militar_rg')->nullable();
            $table->string('militar_nome')->nullable();
            $table->string('militar_posto_graduacao')->nullable();
            $table->string('militar_quadro_qbmp')->nullable();
            $table->string('militar_boletim')->nullable();
            $table->integer('militar_lotacao_id')->nullable();
            $table->string('militar_lotacao')->nullable();

            //Dados do Pagamento (ressarcimento_pagamentos)
            $table->float('pagamento_bruto', 10, 2)->nullable();
            $table->float('pagamento_etapa_ferias', 10, 2)->nullable();
            $table->float('pagamento_etapa_destacado', 10, 2)->nullable();
            $table->float('pagamento_hospital10', 10, 2)->nullable();
            $table->float('pagamento_rioprevidencia22', 10, 2)->nullable();
            $table->float('pagamento_fundo_saude', 10, 2)->nullable();

            //Dados da listagem (ressarcimento_cobrancas_pdfs_listagens)
            $table->float('listagem_vencimento_bruto', 10, 2)->nullable();
            $table->float('listagem_fundo_saude_10', 10, 2)->nullable();
            $table->float('listagem_rioprevidencia22', 10, 2)->nullable();
            $table->float('listagem_fonte10', 10, 2)->nullable();
            $table->float('listagem_folha_suplementar', 10, 2)->nullable();
            $table->float('listagem_valor_total', 10, 2)->nullable();

            //Dados da Configuração (ressarcimento_configuracoes)
            $table->date('configuracao_data_vencimento')->nullable();
            $table->string('configuracao_diretor_identidade_funcional')->nullable();
            $table->string('configuracao_diretor_rg')->nullable();
            $table->string('configuracao_diretor_nome')->nullable();
            $table->string('configuracao_diretor_posto')->nullable();
            $table->string('configuracao_diretor_quadro')->nullable();
            $table->string('configuracao_diretor_cargo')->nullable();
            $table->string('configuracao_dgf2_identidade_funcional')->nullable();
            $table->string('configuracao_dgf2_rg')->nullable();
            $table->string('configuracao_dgf2_nome')->nullable();
            $table->string('configuracao_dgf2_posto')->nullable();
            $table->string('configuracao_dgf2_quadro')->nullable();
            $table->string('configuracao_dgf2_cargo')->nullable();

            //Dados da Nota
            $table->integer('nota_numero')->nullable();
            $table->integer('nota_ano')->nullable();

            //Dados do Ofício
            $table->integer('oficio_numero')->nullable();
            $table->integer('oficio_ano')->nullable();

            //Dados Gerais
            $table->string('oe_cobrar')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_cobrancas_dados');
    }
}
