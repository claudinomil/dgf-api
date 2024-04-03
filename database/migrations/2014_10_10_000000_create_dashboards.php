<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agrupamento_id')->constrained('agrupamentos');
            $table->string('name');
            $table->string('descricao');
            $table->integer('largura')->default(4);
            $table->integer('ordem_visualizacao');
            $table->integer('principal_dashboard_id')->default(0); //Se for 0(Zero) é o Card Principal / Se não é o id do dashbord Principal
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dashboards');
    }
};
