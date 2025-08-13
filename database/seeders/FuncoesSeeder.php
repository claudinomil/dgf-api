<?php

namespace Database\Seeders;

use App\Models\Funcao;
use Illuminate\Database\Seeder;

class FuncoesSeeder extends Seeder
{
    public function run()
    {
        Funcao::create(['id' => 1, 'name' => 'COMANDANTE', 'ordem_visualizacao' => 10]);
        Funcao::create(['id' => 2, 'name' => 'SUBCOMANDANTE', 'ordem_visualizacao' => 20]);
        Funcao::create(['id' => 3, 'name' => 'DIRETOR', 'ordem_visualizacao' => 30]);
        Funcao::create(['id' => 4, 'name' => 'SUBDIRETOR', 'ordem_visualizacao' => 40]);
        Funcao::create(['id' => 5, 'name' => 'CHEFE', 'ordem_visualizacao' => 50]);
        Funcao::create(['id' => 6, 'name' => 'SUBCHEFE', 'ordem_visualizacao' => 60]);
        Funcao::create(['id' => 7, 'name' => 'Defensor(a) Público(a)', 'ordem_visualizacao' => 70]);
        Funcao::create(['id' => 8, 'name' => 'Deputado(a) Estadual', 'ordem_visualizacao' => 80]);
        Funcao::create(['id' => 9, 'name' => 'Governador(a)', 'ordem_visualizacao' => 90]);
        Funcao::create(['id' => 10, 'name' => 'Prefeito(a)', 'ordem_visualizacao' => 100]);
        Funcao::create(['id' => 11, 'name' => 'Presidente', 'ordem_visualizacao' => 110]);
        Funcao::create(['id' => 12, 'name' => 'Procurador(a)-Geral', 'ordem_visualizacao' => 120]);
        Funcao::create(['id' => 13, 'name' => 'Secretário(a)', 'ordem_visualizacao' => 130]);
        Funcao::create(['id' => 14, 'name' => 'Vereador(a)', 'ordem_visualizacao' => 140]);
    }
}
