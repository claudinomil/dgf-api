<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grupos_dashboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupos');
            $table->foreignId('dashboard_id')->constrained('dashboards');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grupos_dashboards');
    }
};
