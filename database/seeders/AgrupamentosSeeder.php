<?php

namespace Database\Seeders;

use App\Models\Agrupamento;
use Illuminate\Database\Seeder;

class AgrupamentosSeeder extends Seeder
{
    public function run()
    {
        Agrupamento::create(['id' => 1, 'name' => 'Cadastros', 'ordem_visualizacao' => 5]);
        Agrupamento::create(['id' => 2, 'name' => 'Ressarcimentos', 'ordem_visualizacao' => 10]);
        Agrupamento::create(['id' => 3, 'name' => 'Valores Unidades', 'ordem_visualizacao' => 15]);
    }
}
