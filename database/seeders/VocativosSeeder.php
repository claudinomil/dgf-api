<?php

namespace Database\Seeders;

use App\Models\Vocativo;
use Illuminate\Database\Seeder;

class VocativosSeeder extends Seeder
{
    public function run()
    {
        Vocativo::create(['id' => 1, 'name' => 'Defensor(a) Público(a)', 'ordem_visualizacao' => 10]);
        Vocativo::create(['id' => 2, 'name' => 'Deputado(a) Estadual', 'ordem_visualizacao' => 20]);
        Vocativo::create(['id' => 3, 'name' => 'Desembargador(a)', 'ordem_visualizacao' => 30]);
        Vocativo::create(['id' => 4, 'name' => 'Gen. Ex.', 'ordem_visualizacao' => 40]);
        Vocativo::create(['id' => 5, 'name' => 'Governador(a)', 'ordem_visualizacao' => 50]);
        Vocativo::create(['id' => 6, 'name' => 'Prefeito(a)', 'ordem_visualizacao' => 60]);
        Vocativo::create(['id' => 7, 'name' => 'Presidente', 'ordem_visualizacao' => 70]);
        Vocativo::create(['id' => 8, 'name' => 'Procurador(a)', 'ordem_visualizacao' => 80]);
        Vocativo::create(['id' => 9, 'name' => 'Secretário(a)', 'ordem_visualizacao' => 90]);
        Vocativo::create(['id' => 10, 'name' => 'Vereador(a)', 'ordem_visualizacao' => 100]);
    }
}
