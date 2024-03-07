<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoRecebimentosTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_recebimentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ressarcimento_cobranca_dado_id')->constrained('ressarcimento_cobrancas_dados', 'id', 'rr_cobranca_dado_id');

            $table->date('data_recebimento')->nullable();
            $table->float('valor_recebido', 10, 2)->nullable();
            $table->float('saldo_restante', 10, 2)->nullable();
            $table->string('guia_recolhimento')->nullable();
            $table->string('documento')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_recebimentos');
    }
}
