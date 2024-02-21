<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessarcimentoReferenciasTable extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_referencias', function (Blueprint $table) {
            $table->id();
            $table->string('referencia')->unique();
            $table->string('ano');
            $table->string('mes');
            $table->string('parte');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_referencias');
    }
}
