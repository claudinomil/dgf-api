<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoOrgaosTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_orgaos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('cnpj', 14)->nullable()->unique();
            $table->string('ug', 11)->nullable();
            $table->string('responsavel')->nullable();
            $table->foreignId('esfera_id')->nullable()->constrained('esferas');
            $table->foreignId('poder_id')->nullable()->constrained('poderes');
            $table->foreignId('tratamento_id')->nullable()->constrained('tratamentos');
            $table->foreignId('vocativo_id')->nullable()->constrained('vocativos');
            $table->foreignId('funcao_id')->nullable()->constrained('funcoes');
            $table->string('telefone_1')->nullable();
            $table->string('telefone_2')->nullable();
            $table->string('cep')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('bairro')->nullable();
            $table->string('localidade')->nullable();
            $table->string('uf')->nullable();

            $table->string('contato_nome')->nullable();
            $table->string('contato_telefone')->nullable();
            $table->string('contato_celular')->nullable();
            $table->string('contato_email')->nullable();

            $table->integer('lotacao_id')->nullable();
            $table->string('lotacao')->nullable();

            $table->integer('realizar_cobranca')->default(1);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_orgaos');
    }
}
