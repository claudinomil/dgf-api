<?php

namespace Database\Seeders;

use App\Models\Funcao;
use Illuminate\Database\Seeder;

class FuncoesSeeder extends Seeder
{
    public function run()
    {
        Funcao::create(['id' => '1', 'name' => 'COMANDANTE', 'ordem_visualizacao' => 10]);
        Funcao::create(['id' => '2', 'name' => 'DIRETOR', 'ordem_visualizacao' => 20]);
        Funcao::create(['id' => '3', 'name' => 'CHEFE', 'ordem_visualizacao' => 30]);
    }
}
