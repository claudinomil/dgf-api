<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoCobrancasPdfsListagensDadosTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_cobrancas_pdfs_listagens_dados', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ressarcimento_cobranca_pdf_listagem_id')->constrained('ressarcimento_cobrancas_pdfs_listagens', 'id', 'rcpld_listagem_id');

            $table->string('militar_identidade_funcional')->nullable();
            $table->string('militar_posto_graduacao')->nullable();
            $table->string('militar_nome')->nullable();
            $table->float('vencimento_bruto', 10, 2)->nullable();
            $table->float('fundo_saude_10', 10, 2)->nullable();
            $table->float('rioprevidencia22', 10, 2)->nullable();
            $table->float('fonte10', 10, 2)->nullable();
            $table->float('folha_suplementar', 10, 2)->nullable();
            $table->float('valor_total', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_cobrancas_pdfs_listagens_dados');
    }
}
