<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->foreignId('grupo_id')->nullable()->constrained('grupos');
            $table->foreignId('situacao_id')->nullable()->constrained('situacoes');
            $table->string('layout_mode')->nullable();
            $table->string('layout_style')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('user_confirmed_at')->nullable();
            $table->string('password');
            $table->text('avatar');

            //Militar de referência para o Usuário
            $table->string('militar_rg')->nullable();
            $table->string('militar_nome')->nullable();
            $table->integer('militar_posto_graduacao_ordem')->nullable();
            $table->string('militar_posto_graduacao')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
