<?php

namespace Database\Seeders;

use App\Models\Dashboard;
use Illuminate\Database\Seeder;

class DashboardsSeeder extends Seeder
{
    public function run()
    {
        //TODOS OS AGRUPAMENTOS PRECISAM TER UM DASHBOARD PRINCIPAL
        //NÃO TROCAR ID'S POIS TEM CÓDIGO HARD CODE

        //agrupamento_id=1 Cadastros
        Dashboard::create(['id' => 1, 'agrupamento_id' => 1, 'name' => 'Principal', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 1, 'principal_dashboard_id' => 0]);
        Dashboard::create(['id' => 2, 'agrupamento_id' => 1, 'name' => 'Usuários Grupos', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 2, 'principal_dashboard_id' => 1]);
        Dashboard::create(['id' => 3, 'agrupamento_id' => 1, 'name' => 'Usuários Posto/Graduação', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 3, 'principal_dashboard_id' => 1]);
        Dashboard::create(['id' => 4, 'agrupamento_id' => 1, 'name' => 'Usuários Situações', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 4, 'principal_dashboard_id' => 1]);
        Dashboard::create(['id' => 5, 'agrupamento_id' => 1, 'name' => 'Transações', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 5, 'principal_dashboard_id' => 1]);

        //agrupamento_id=2 Ressarcimentos
        Dashboard::create(['id' => 6, 'agrupamento_id' => 2, 'name' => 'Principal', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 1, 'principal_dashboard_id' => 0]);
        Dashboard::create(['id' => 7, 'agrupamento_id' => 2, 'name' => 'Quantidade de Militares: Oficiais/Praças', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 4, 'principal_dashboard_id' => 6]);
        Dashboard::create(['id' => 8, 'agrupamento_id' => 2, 'name' => 'Valores Devidos e Pagos pelos Órgãos', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 5, 'principal_dashboard_id' => 6]);
        Dashboard::create(['id' => 9, 'agrupamento_id' => 2, 'name' => 'Número de Órgãos por Esfera', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 2, 'principal_dashboard_id' => 6]);
        Dashboard::create(['id' => 10, 'agrupamento_id' => 2, 'name' => 'Número de Órgãos por Poder', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 3, 'principal_dashboard_id' => 6]);
        Dashboard::create(['id' => 11, 'agrupamento_id' => 2, 'name' => 'Valores Devidos e Pagos por Órgãos mensalmente', 'descricao' => '', 'largura' => 12, 'ordem_visualizacao' => 6, 'principal_dashboard_id' => 6]);

        //agrupamento_id=3 Valores Unidades
        Dashboard::create(['id' => 12, 'agrupamento_id' => 3, 'name' => 'Principal', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 1, 'principal_dashboard_id' => 0]);
        Dashboard::create(['id' => 13, 'agrupamento_id' => 3, 'name' => 'Repasses', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 2, 'principal_dashboard_id' => 12]);
        Dashboard::create(['id' => 14, 'agrupamento_id' => 3, 'name' => 'Despesas', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 3, 'principal_dashboard_id' => 12]);
        Dashboard::create(['id' => 15, 'agrupamento_id' => 3, 'name' => 'Transferências Realizadas', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 4, 'principal_dashboard_id' => 12]);
        Dashboard::create(['id' => 16, 'agrupamento_id' => 3, 'name' => 'Transferências Recebidas', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 5, 'principal_dashboard_id' => 12]);
        Dashboard::create(['id' => 17, 'agrupamento_id' => 3, 'name' => 'Resultado do Período', 'descricao' => '', 'largura' => 4, 'ordem_visualizacao' => 6, 'principal_dashboard_id' => 12]);
    }
}
