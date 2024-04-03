<?php

namespace Database\Seeders;

use App\Models\Esfera;
use Illuminate\Database\Seeder;

class EsferasSeeder extends Seeder
{
    public function run()
    {
        Esfera::create(['id' => '1', 'name' => 'UNIÃO', 'ordem_visualizacao' => 10]);
        Esfera::create(['id' => '2', 'name' => 'ESTADOS', 'ordem_visualizacao' => 20]);
        Esfera::create(['id' => '3', 'name' => 'MUNICÍPIOS', 'ordem_visualizacao' => 30]);
    }
}
