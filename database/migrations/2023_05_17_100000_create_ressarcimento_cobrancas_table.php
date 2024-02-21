<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoCobrancasTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_cobrancas', function (Blueprint $table) {
            $table->id();
            $table->string('referencia');
            $table->integer('cobranca_encerrada')->default(0);
            $table->date('data_encerramento')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_cobrancas');
    }
}
