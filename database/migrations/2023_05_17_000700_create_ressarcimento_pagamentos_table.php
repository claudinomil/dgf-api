<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoPagamentosTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_pagamentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ressarcimento_militar_id')->constrained('ressarcimento_militares');

            $table->string('referencia');
            $table->string('identidade_funcional')->nullable();
            $table->string('vinculo')->nullable();
            $table->string('rg')->nullable();
            $table->string('codigo_cargo')->nullable();
            $table->string('nome_cargo')->nullable();
            $table->string('posto_graduacao')->nullable();
            $table->string('nivel')->nullable();
            $table->string('nome')->nullable();
            $table->string('situacao_pagamento')->nullable();
            $table->date('data_ingresso')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->date('data_aposentadoria')->nullable();
            $table->string('genero')->nullable();
            $table->string('codigo_ua')->nullable();
            $table->string('ua')->nullable();
            $table->string('cpf')->nullable();
            $table->string('pasep')->nullable();
            $table->string('banco')->nullable();
            $table->string('agencia')->nullable();
            $table->string('conta_corrente')->nullable();
            $table->string('numero_dependentes')->nullable();
            $table->string('ir_dependente')->nullable();
            $table->string('cotista')->nullable();
            $table->float('bruto', 10, 2)->nullable()->default(0);
            $table->float('desconto', 10, 2)->nullable()->default(0);
            $table->float('liquido', 10, 2)->nullable()->default(0);
            $table->float('soldo', 10, 2)->nullable()->default(0);
            $table->float('hospital10', 10, 2)->nullable()->default(0);
            $table->float('rioprevidencia22', 10, 2)->nullable()->default(0);
            $table->float('etapa_ferias', 10, 2)->nullable()->default(0);
            $table->float('etapa_destacado', 10, 2)->nullable()->default(0);
            $table->float('ajuda_fardamento', 10, 2)->nullable()->default(0);
            $table->float('habilitacao_profissional', 10, 2)->nullable()->default(0);
            $table->float('gret', 10, 2)->nullable()->default(0);
            $table->float('auxilio_moradia', 10, 2)->nullable()->default(0);
            $table->float('gpe', 10, 2)->nullable()->default(0);
            $table->float('gee_capacitacao', 10, 2)->nullable()->default(0);
            $table->float('decreto14407', 10, 2)->nullable()->default(0);
            $table->float('ferias', 10, 2)->nullable()->default(0);
            $table->float('raio_x', 10, 2)->nullable()->default(0);
            $table->float('trienio', 10, 2)->nullable()->default(0);
            $table->float('auxilio_invalidez', 10, 2)->nullable()->default(0);
            $table->float('tempo_certo', 10, 2)->nullable()->default(0);
            $table->float('fundo_saude', 10, 2)->nullable()->default(0);
            $table->float('abono_permanencia', 10, 2)->nullable()->default(0);
            $table->float('deducao_ir', 10, 2)->nullable()->default(0);
            $table->float('ir_valor', 10, 2)->nullable()->default(0);
            $table->float('auxilio_transporte', 10, 2)->nullable()->default(0);
            $table->float('gram', 10, 2)->nullable()->default(0);
            $table->float('auxilio_fardamento', 10, 2)->nullable()->default(0);
            $table->string('cidade')->nullable();
            $table->text('observacao')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_pagamentos');
    }
}
