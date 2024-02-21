<?php

namespace Database\Seeders;

use App\Models\Dashboard;
use Illuminate\Database\Seeder;

class DashboardsSeeder extends Seeder
{
    public function run()
    {
        //modulo_id=1 : Home
        Dashboard::create(['id' => 1, 'modulo_id' => 1, 'name' => 'Principal', 'descricao' => '', 'ordem_visualizacao' => 1]);
        Dashboard::create(['id' => 2, 'modulo_id' => 1, 'name' => 'Usuários Grupos', 'descricao' => '', 'ordem_visualizacao' => 2]);
        Dashboard::create(['id' => 3, 'modulo_id' => 1, 'name' => 'Usuários Posto/Graduação', 'descricao' => '', 'ordem_visualizacao' => 3]);
        Dashboard::create(['id' => 4, 'modulo_id' => 1, 'name' => 'Usuários Situações', 'descricao' => '', 'ordem_visualizacao' => 4]);
        Dashboard::create(['id' => 5, 'modulo_id' => 1, 'name' => 'Transações', 'descricao' => '', 'ordem_visualizacao' => 5]);

        //modulo_id=3 : Ressarcimento
        Dashboard::create(['id' => 6, 'modulo_id' => 3, 'name' => 'Principal', 'descricao' => '', 'ordem_visualizacao' => 1]);
        Dashboard::create(['id' => 7, 'modulo_id' => 3, 'name' => 'Quantidade de Militares: Oficiais/Praças', 'descricao' => '', 'ordem_visualizacao' => 4]);
        Dashboard::create(['id' => 8, 'modulo_id' => 3, 'name' => 'Valores Devidos e Pagos pelos Órgãos', 'descricao' => '', 'ordem_visualizacao' => 5]);
        Dashboard::create(['id' => 9, 'modulo_id' => 3, 'name' => 'Número de Órgãos por Esfera', 'descricao' => '', 'ordem_visualizacao' => 2]);
        Dashboard::create(['id' => 10, 'modulo_id' => 3, 'name' => 'Número de Órgãos por Poder', 'descricao' => '', 'ordem_visualizacao' => 3]);
        Dashboard::create(['id' => 11, 'modulo_id' => 3, 'name' => 'Valores Devidos e Pagos por Órgãos mensalmente', 'descricao' => '', 'ordem_visualizacao' => 6]);
    }
}
