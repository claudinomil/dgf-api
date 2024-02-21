<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('user_confirmed_at')->nullable();
            $table->string('password');
            $table->text('avatar');
            $table->string('layout_mode');
            $table->string('layout_style');
            $table->foreignId('grupo_id')->constrained('grupos');
            $table->foreignId('situacao_id')->default(2)->constrained('situacoes');

            //Militar de referência para o Usuário
            $table->string('militar_rg')->nullable();
            $table->string('militar_nome')->nullable();
            $table->integer('militar_posto_graduacao_ordem')->nullable();
            $table->string('militar_posto_graduacao')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
