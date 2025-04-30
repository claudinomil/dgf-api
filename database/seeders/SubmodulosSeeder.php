<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmodulosSeeder extends Seeder
{
    public function run()
    {
        DB::table('submodulos')->insert([
            ['id' => '9', 'modulo_id' => '1', 'name' => 'Usuários Perfil', 'menu_text' => 'Usuários Perfil', 'menu_url' => 'users_perfil', 'menu_route' => 'users_perfil', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'users_perfil', 'prefix_route' => 'users_perfil', 'descricao' => '', 'ordem_visualizacao' => 0],

            //Módulo: Home
            ['id' => '8', 'modulo_id' => '1', 'name' => 'Dashboards', 'menu_text' => 'Dashboards', 'menu_url' => 'dashboards', 'menu_route' => 'dashboards', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'dashboards', 'prefix_route' => 'dashboards', 'descricao' => '', 'ordem_visualizacao' => 5],
            ['id' => '2', 'modulo_id' => '1', 'name' => 'Grupos', 'menu_text' => 'Grupos', 'menu_url' => 'grupos', 'menu_route' => 'grupos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'grupos', 'prefix_route' => 'grupos', 'descricao' => '', 'ordem_visualizacao' => 10],
            ['id' => '1', 'modulo_id' => '1', 'name' => 'Usuários', 'menu_text' => 'Usuários', 'menu_url' => 'users', 'menu_route' => 'users', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'users', 'prefix_route' => 'users', 'descricao' => '', 'ordem_visualizacao' => 15],
            ['id' => '4', 'modulo_id' => '1', 'name' => 'Log de Transações', 'menu_text' => 'Log de Transações', 'menu_url' => 'transacoes', 'menu_route' => 'transacoes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'transacoes', 'prefix_route' => 'transacoes', 'descricao' => '', 'ordem_visualizacao' => 20],
            ['id' => '3', 'modulo_id' => '1', 'name' => 'Notificações', 'menu_text' => 'Notificações', 'menu_url' => 'notificacoes', 'menu_route' => 'notificacoes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'notificacoes', 'prefix_route' => 'notificacoes', 'descricao' => '', 'ordem_visualizacao' => 30],
            ['id' => '5', 'modulo_id' => '1', 'name' => 'Ferramentas', 'menu_text' => 'Ferramentas', 'menu_url' => 'ferramentas', 'menu_route' => 'ferramentas', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'ferramentas', 'prefix_route' => 'ferramentas', 'descricao' => '', 'ordem_visualizacao' => 35],
            ['id' => '17', 'modulo_id' => '1', 'name' => 'Relatórios', 'menu_text' => 'Relatórios', 'menu_url' => 'relatorios', 'menu_route' => 'relatorios', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'relatorios', 'prefix_route' => 'relatorios', 'descricao' => '', 'ordem_visualizacao' => 100],

            //Módulo: Auxiliares

            //Módulo: Ressarcimento
            ['id' => '7', 'modulo_id' => '3', 'name' => 'Ressarcimento - Referências', 'menu_text' => 'Referências', 'menu_url' => 'ressarcimento_referencias', 'menu_route' => 'ressarcimento_referencias', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'ressarcimento_referencias', 'prefix_route' => 'ressarcimento_referencias', 'descricao' => '', 'ordem_visualizacao' => 10],
            ['id' => '10', 'modulo_id' => '3', 'name' => 'Ressarcimento - Órgãos', 'menu_text' => 'Órgãos', 'menu_url' => 'ressarcimento_orgaos', 'menu_route' => 'ressarcimento_orgaos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'ressarcimento_orgaos', 'prefix_route' => 'ressarcimento_orgaos', 'descricao' => '', 'ordem_visualizacao' => 20],
            ['id' => '12', 'modulo_id' => '3', 'name' => 'Ressarcimento - Militares', 'menu_text' => 'Militares', 'menu_url' => 'ressarcimento_militares', 'menu_route' => 'ressarcimento_militares', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'ressarcimento_militares', 'prefix_route' => 'ressarcimento_militares', 'descricao' => '', 'ordem_visualizacao' => 30],
            ['id' => '11', 'modulo_id' => '3', 'name' => 'Ressarcimento - Pagamentos', 'menu_text' => 'Pagamentos', 'menu_url' => 'ressarcimento_pagamentos', 'menu_route' => 'ressarcimento_pagamentos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'ressarcimento_pagamentos', 'prefix_route' => 'ressarcimento_pagamentos', 'descricao' => '', 'ordem_visualizacao' => 40],
            ['id' => '6', 'modulo_id' => '3', 'name' => 'Ressarcimento - Configurações', 'menu_text' => 'Configurações', 'menu_url' => 'ressarcimento_configuracoes', 'menu_route' => 'ressarcimento_configuracoes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'ressarcimento_configuracoes', 'prefix_route' => 'ressarcimento_configuracoes', 'descricao' => '', 'ordem_visualizacao' => 50],
            ['id' => '13', 'modulo_id' => '3', 'name' => 'Ressarcimento - Cobranças', 'menu_text' => 'Cobranças', 'menu_url' => 'ressarcimento_cobrancas', 'menu_route' => 'ressarcimento_cobrancas', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'ressarcimento_cobrancas', 'prefix_route' => 'ressarcimento_cobrancas', 'descricao' => '', 'ordem_visualizacao' => 60],
            ['id' => '14', 'modulo_id' => '3', 'name' => 'Ressarcimento - Recebimentos', 'menu_text' => 'Recebimentos', 'menu_url' => 'ressarcimento_recebimentos', 'menu_route' => 'ressarcimento_recebimentos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'ressarcimento_recebimentos', 'prefix_route' => 'ressarcimento_recebimentos', 'descricao' => '', 'ordem_visualizacao' => 70],

            //Módulo: Efetivo
            ['id' => '18', 'modulo_id' => '5', 'name' => 'Efetivo - Militares', 'menu_text' => 'Militares', 'menu_url' => 'efetivo_militares', 'menu_route' => 'efetivo_militares', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'efetivo_militares', 'prefix_route' => 'efetivo_militares', 'descricao' => '', 'ordem_visualizacao' => 10],

            //Módulo: Alimentação
            ['id' => '19', 'modulo_id' => '6', 'name' => 'Alimentação - Tipos', 'menu_text' => 'Tipos', 'menu_url' => 'alimentacao_tipos', 'menu_route' => 'alimentacao_tipos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'alimentacao_tipos', 'prefix_route' => 'alimentacao_tipos', 'descricao' => '', 'ordem_visualizacao' => 10],
            ['id' => '20', 'modulo_id' => '6', 'name' => 'Alimentação - Planos', 'menu_text' => 'Planos', 'menu_url' => 'alimentacao_planos', 'menu_route' => 'alimentacao_planos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'alimentacao_planos', 'prefix_route' => 'alimentacao_planos', 'descricao' => '', 'ordem_visualizacao' => 20],
            ['id' => '21', 'modulo_id' => '6', 'name' => 'Alimentação - Unidades', 'menu_text' => 'Unidades', 'menu_url' => 'alimentacao_unidades', 'menu_route' => 'alimentacao_unidades', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'alimentacao_unidades', 'prefix_route' => 'alimentacao_unidades', 'descricao' => '', 'ordem_visualizacao' => 30],
            ['id' => '22', 'modulo_id' => '6', 'name' => 'Alimentação - Remanejamentos', 'menu_text' => 'Remanejamentos', 'menu_url' => 'alimentacao_remanejamentos', 'menu_route' => 'alimentacao_remanejamentos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'alimentacao_remanejamentos', 'prefix_route' => 'alimentacao_remanejamentos', 'descricao' => '', 'ordem_visualizacao' => 30],
            ['id' => '23', 'modulo_id' => '6', 'name' => 'Alimentação - Quantitativos', 'menu_text' => 'Quantitativos', 'menu_url' => 'alimentacao_quantitativos', 'menu_route' => 'alimentacao_quantitativos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'alimentacao_quantitativos', 'prefix_route' => 'alimentacao_quantitativos', 'descricao' => '', 'ordem_visualizacao' => 40],

            //Módulo: Auxiliares SAD
            ['id' => '24', 'modulo_id' => '7', 'name' => 'Informações', 'menu_text' => 'Informações', 'menu_url' => 'sad_militares_informacoes', 'menu_route' => 'sad_militares_informacoes', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'sad_militares_informacoes', 'prefix_route' => 'sad_militares_informacoes', 'descricao' => '', 'ordem_visualizacao' => 10],
        ]);
    }
}
