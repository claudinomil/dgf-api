<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocativosTable extends Migration
{
    public function up()
    {
        Schema::create('vocativos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('viewing_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vocativos');
    }
}
