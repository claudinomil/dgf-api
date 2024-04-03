<?php

namespace Database\Seeders;

use App\Models\Agrupamento;
use Illuminate\Database\Seeder;

class AgrupamentosSeeder extends Seeder
{
    public function run()
    {
        Agrupamento::create(['id' => 1, 'name' => 'Cadastros', 'icone' => 'fa fa-clipboard-list', 'ordem_visualizacao' => 5]);
        Agrupamento::create(['id' => 2, 'name' => 'Ressarcimentos', 'icone' => 'fa fa-file-invoice-dollar', 'ordem_visualizacao' => 10]);
        Agrupamento::create(['id' => 3, 'name' => 'Valores Unidades', 'icone' => 'fa fa-money-check-alt', 'ordem_visualizacao' => 15]);
    }
}
