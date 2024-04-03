<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users_dashboards_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('dashboard_id')->constrained('dashboards');
            $table->integer('largura')->default(4);
            $table->integer('ordem_visualizacao')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_dashboards_views');
    }
};
