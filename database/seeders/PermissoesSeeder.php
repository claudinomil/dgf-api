<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permissao;

class PermissoesSeeder extends Seeder
{
    public function run()
    {
        Permissao::create(['id' => 1, 'submodulo_id' => 1, 'name' => 'users_list', 'description' => 'Visualizar Registro - Usuários']);
        Permissao::create(['id' => 2, 'submodulo_id' => 1, 'name' => 'users_create', 'description' => 'Criar Registro - Usuários']);
        Permissao::create(['id' => 3, 'submodulo_id' => 1, 'name' => 'users_show', 'description' => 'Visualizar Registro - Usuários']);
        Permissao::create(['id' => 4, 'submodulo_id' => 1, 'name' => 'users_edit', 'description' => 'Editar Registro - Usuários']);
        Permissao::create(['id' => 5, 'submodulo_id' => 1, 'name' => 'users_destroy', 'description' => 'Deletar Registro - Usuários']);

        Permissao::create(['id' => 6, 'submodulo_id' => 2, 'name' => 'grupos_list', 'description' => 'Visualizar Registro - Grupos']);
        Permissao::create(['id' => 7, 'submodulo_id' => 2, 'name' => 'grupos_create', 'description' => 'Criar Registro - Grupos']);
        Permissao::create(['id' => 8, 'submodulo_id' => 2, 'name' => 'grupos_show', 'description' => 'Visualizar Registro - Grupos']);
        Permissao::create(['id' => 9, 'submodulo_id' => 2, 'name' => 'grupos_edit', 'description' => 'Editar Registro - Grupos']);
        Permissao::create(['id' => 10, 'submodulo_id' => 2, 'name' => 'grupos_destroy', 'description' => 'Deletar Registro - Grupos']);

        Permissao::create(['id' => 11, 'submodulo_id' => 3, 'name' => 'notificacoes_list', 'description' => 'Visualizar Registro - Notificações']);
        Permissao::create(['id' => 12, 'submodulo_id' => 3, 'name' => 'notificacoes_create', 'description' => 'Criar Registro - Notificações']);
        Permissao::create(['id' => 13, 'submodulo_id' => 3, 'name' => 'notificacoes_show', 'description' => 'Visualizar Registro - Notificações']);
        Permissao::create(['id' => 14, 'submodulo_id' => 3, 'name' => 'notificacoes_edit', 'description' => 'Editar Registro - Notificações']);
        Permissao::create(['id' => 15, 'submodulo_id' => 3, 'name' => 'notificacoes_destroy', 'description' => 'Deletar Registro - Notificações']);

        Permissao::create(['id' => 16, 'submodulo_id' => 4, 'name' => 'transacoes_list', 'description' => 'Visualizar Registro - Transações']);
        Permissao::create(['id' => 17, 'submodulo_id' => 4, 'name' => 'transacoes_create', 'description' => 'Criar Registro - Transações']);
        Permissao::create(['id' => 18, 'submodulo_id' => 4, 'name' => 'transacoes_show', 'description' => 'Visualizar Registro - Transações']);
        Permissao::create(['id' => 19, 'submodulo_id' => 4, 'name' => 'transacoes_edit', 'description' => 'Editar Registro - Transações']);
        Permissao::create(['id' => 20, 'submodulo_id' => 4, 'name' => 'transacoes_destroy', 'description' => 'Deletar Registro - Transações']);

        Permissao::create(['id' => 21, 'submodulo_id' => 5, 'name' => 'ferramentas_list', 'description' => 'Visualizar Registro - Ferramentas']);
        Permissao::create(['id' => 22, 'submodulo_id' => 5, 'name' => 'ferramentas_create', 'description' => 'Criar Registro - Ferramentas']);
        Permissao::create(['id' => 23, 'submodulo_id' => 5, 'name' => 'ferramentas_show', 'description' => 'Visualizar Registro - Ferramentas']);
        Permissao::create(['id' => 24, 'submodulo_id' => 5, 'name' => 'ferramentas_edit', 'description' => 'Editar Registro - Ferramentas']);
        Permissao::create(['id' => 25, 'submodulo_id' => 5, 'name' => 'ferramentas_destroy', 'description' => 'Deletar Registro - Ferramentas']);

        Permissao::create(['id' => 26, 'submodulo_id' => 8, 'name' => 'dashboards_list', 'description' => 'Visualizar Registro - Dashboards']);
        //Permissao::create(['id' => 27, 'submodulo_id' => 8, 'name' => 'dashboards_create', 'description' => 'Criar Registro - Dashboards']);
        //Permissao::create(['id' => 28, 'submodulo_id' => 8, 'name' => 'dashboards_show', 'description' => 'Visualizar Registro - Dashboards']);
        //Permissao::create(['id' => 29, 'submodulo_id' => 8, 'name' => 'dashboards_edit', 'description' => 'Editar Registro - Dashboards']);
        //Permissao::create(['id' => 30, 'submodulo_id' => 8, 'name' => 'dashboards_destroy', 'description' => 'Deletar Registro - Dashboards']);

        Permissao::create(['id' => 31, 'submodulo_id' => 9, 'name' => 'users_perfil_show', 'description' => 'Visualizar Registro - Usuários Perfil']);
        Permissao::create(['id' => 32, 'submodulo_id' => 9, 'name' => 'users_perfil_edit', 'description' => 'Editar Registro - Usuários Perfil']);

        Permissao::create(['id' => 33, 'submodulo_id' => 10, 'name' => 'ressarcimento_orgaos_list', 'description' => 'Visualizar Registro - Ressarcimento Órgãos']);
        //Permissao::create(['id' => 34, 'submodulo_id' => 10, 'name' => 'ressarcimento_orgaos_create', 'description' => 'Criar Registro - Ressarcimento Órgãos']);
        Permissao::create(['id' => 35, 'submodulo_id' => 10, 'name' => 'ressarcimento_orgaos_show', 'description' => 'Visualizar Registro - Ressarcimento Órgãos']);
        Permissao::create(['id' => 36, 'submodulo_id' => 10, 'name' => 'ressarcimento_orgaos_edit', 'description' => 'Editar Registro - Ressarcimento Órgãos']);
        //Permissao::create(['id' => 37, 'submodulo_id' => 10, 'name' => 'ressarcimento_orgaos_destroy', 'description' => 'Deletar Registro - Ressarcimento Órgãos']);

        Permissao::create(['id' => 38, 'submodulo_id' => 11, 'name' => 'ressarcimento_pagamentos_list', 'description' => 'Visualizar Registro - Ressarcimento Pagamentos']);
        Permissao::create(['id' => 39, 'submodulo_id' => 11, 'name' => 'ressarcimento_pagamentos_create', 'description' => 'Criar Registro - Ressarcimento Pagamentos']);
        Permissao::create(['id' => 40, 'submodulo_id' => 11, 'name' => 'ressarcimento_pagamentos_show', 'description' => 'Visualizar Registro - Ressarcimento Pagamentos']);
        Permissao::create(['id' => 41, 'submodulo_id' => 11, 'name' => 'ressarcimento_pagamentos_edit', 'description' => 'Editar Registro - Ressarcimento Pagamentos']);
        Permissao::create(['id' => 42, 'submodulo_id' => 11, 'name' => 'ressarcimento_pagamentos_destroy', 'description' => 'Deletar Registro - Ressarcimento Pagamentos']);

        Permissao::create(['id' => 43, 'submodulo_id' => 12, 'name' => 'ressarcimento_militares_list', 'description' => 'Visualizar Registro - Ressarcimento Militares']);
        Permissao::create(['id' => 44, 'submodulo_id' => 12, 'name' => 'ressarcimento_militares_create', 'description' => 'Criar Registro - Ressarcimento Militares']);
        Permissao::create(['id' => 45, 'submodulo_id' => 12, 'name' => 'ressarcimento_militares_show', 'description' => 'Visualizar Registro - Ressarcimento Militares']);
        //Permissao::create(['id' => 46, 'submodulo_id' => 12, 'name' => 'ressarcimento_militares_edit', 'description' => 'Editar Registro - Ressarcimento Militares']);
        Permissao::create(['id' => 47, 'submodulo_id' => 12, 'name' => 'ressarcimento_militares_destroy', 'description' => 'Deletar Registro - Ressarcimento Militares']);

        Permissao::create(['id' => 48, 'submodulo_id' => 13, 'name' => 'ressarcimento_cobrancas_list', 'description' => 'Visualizar Registro - Ressarcimento Dashboards']);
        //Permissao::create(['id' => 49, 'submodulo_id' => 13, 'name' => 'ressarcimento_cobrancas_create', 'description' => 'Criar Registro - Ressarcimento Dashboards']);
        //Permissao::create(['id' => 50, 'submodulo_id' => 13, 'name' => 'ressarcimento_cobrancas_show', 'description' => 'Visualizar Registro - Ressarcimento Dashboards']);
        //Permissao::create(['id' => 51, 'submodulo_id' => 13, 'name' => 'ressarcimento_cobrancas_edit', 'description' => 'Editar Registro - Ressarcimento Dashboards']);
        //Permissao::create(['id' => 52, 'submodulo_id' => 13, 'name' => 'ressarcimento_cobrancas_destroy', 'description' => 'Deletar Registro - Ressarcimento Dashboards']);

        Permissao::create(['id' => 53, 'submodulo_id' => 6, 'name' => 'ressarcimento_configuracoes_list', 'description' => 'Visualizar Registro - Ressarcimento Configurações']);
        //Permissao::create(['id' => 54, 'submodulo_id' => 6, 'name' => 'ressarcimento_configuracoes_create', 'description' => 'Criar Registro - Ressarcimento Configurações']);
        Permissao::create(['id' => 55, 'submodulo_id' => 6, 'name' => 'ressarcimento_configuracoes_show', 'description' => 'Visualizar Registro - Ressarcimento Configurações']);
        Permissao::create(['id' => 56, 'submodulo_id' => 6, 'name' => 'ressarcimento_configuracoes_edit', 'description' => 'Editar Registro - Ressarcimento Configurações']);
        //Permissao::create(['id' => 57, 'submodulo_id' => 6, 'name' => 'ressarcimento_configuracoes_destroy', 'description' => 'Deletar Registro - Ressarcimento Configurações']);

        Permissao::create(['id' => 58, 'submodulo_id' => 7, 'name' => 'ressarcimento_referencias_list', 'description' => 'Visualizar Registro - Ressarcimento Referências']);
        Permissao::create(['id' => 59, 'submodulo_id' => 7, 'name' => 'ressarcimento_referencias_create', 'description' => 'Criar Registro - Ressarcimento Referências']);
        Permissao::create(['id' => 60, 'submodulo_id' => 7, 'name' => 'ressarcimento_referencias_show', 'description' => 'Visualizar Registro - Ressarcimento Referências']);
        Permissao::create(['id' => 61, 'submodulo_id' => 7, 'name' => 'ressarcimento_referencias_edit', 'description' => 'Editar Registro - Ressarcimento Referências']);
        Permissao::create(['id' => 62, 'submodulo_id' => 7, 'name' => 'ressarcimento_referencias_destroy', 'description' => 'Deletar Registro - Ressarcimento Referências']);

        Permissao::create(['id' => 63, 'submodulo_id' => 14, 'name' => 'ressarcimento_recebimentos_list', 'description' => 'Visualizar Registro - Ressarcimento Recebimentos']);
        //Permissao::create(['id' => 64, 'submodulo_id' => 14, 'name' => 'ressarcimento_recebimentos_create', 'description' => 'Criar Registro - Ressarcimento Recebimentos']);
        Permissao::create(['id' => 65, 'submodulo_id' => 14, 'name' => 'ressarcimento_recebimentos_show', 'description' => 'Visualizar Registro - Ressarcimento Recebimentos']);
        Permissao::create(['id' => 66, 'submodulo_id' => 14, 'name' => 'ressarcimento_recebimentos_edit', 'description' => 'Editar Registro - Ressarcimento Recebimentos']);
        //Permissao::create(['id' => 67, 'submodulo_id' => 14, 'name' => 'ressarcimento_recebimentos_destroy', 'description' => 'Deletar Registro - Ressarcimento Recebimentos']);

        Permissao::create(['id' => 78, 'submodulo_id' => 17, 'name' => 'relatorios_list', 'description' => 'Visualizar Registro - Relatórios']);
        //Permissao::create(['id' => 79, 'submodulo_id' => 17, 'name' => 'relatorios_create', 'description' => 'Criar Registro - Relatórios']);
        //Permissao::create(['id' => 80, 'submodulo_id' => 17, 'name' => 'relatorios_show', 'description' => 'Visualizar Registro - Relatórios']);
        //Permissao::create(['id' => 81, 'submodulo_id' => 17, 'name' => 'relatorios_edit', 'description' => 'Editar Registro - Relatórios']);
        //Permissao::create(['id' => 82, 'submodulo_id' => 17, 'name' => 'relatorios_destroy', 'description' => 'Deletar Registro - Relatórios']);

        Permissao::create(['id' => 83, 'submodulo_id' => 18, 'name' => 'efetivo_militares_list', 'description' => 'Visualizar Registro - Efetivo Militares']);
        //Permissao::create(['id' => 84, 'submodulo_id' => 18, 'name' => 'efetivo_militares_create', 'description' => 'Criar Registro - Efetivo Militares']);
        Permissao::create(['id' => 85, 'submodulo_id' => 18, 'name' => 'efetivo_militares_show', 'description' => 'Visualizar Registro - Efetivo Militares']);
        //Permissao::create(['id' => 86, 'submodulo_id' => 18, 'name' => 'efetivo_militares_edit', 'description' => 'Editar Registro - Efetivo Militares']);
        //Permissao::create(['id' => 87, 'submodulo_id' => 18, 'name' => 'efetivo_militares_destroy', 'description' => 'Deletar Registro - Efetivo Militares']);

        Permissao::create(['id' => 88, 'submodulo_id' => 19, 'name' => 'alimentacao_tipos_list', 'description' => 'Visualizar Registro - Alimentação Tipos']);
        Permissao::create(['id' => 89, 'submodulo_id' => 19, 'name' => 'alimentacao_tipos_create', 'description' => 'Criar Registro - Alimentação Tipos']);
        Permissao::create(['id' => 90, 'submodulo_id' => 19, 'name' => 'alimentacao_tipos_show', 'description' => 'Visualizar Registro - Alimentação Tipos']);
        Permissao::create(['id' => 91, 'submodulo_id' => 19, 'name' => 'alimentacao_tipos_edit', 'description' => 'Editar Registro - Alimentação Tipos']);
        Permissao::create(['id' => 92, 'submodulo_id' => 19, 'name' => 'alimentacao_tipos_destroy', 'description' => 'Deletar Registro - Alimentação Tipos']);

        Permissao::create(['id' => 93, 'submodulo_id' => 20, 'name' => 'alimentacao_planos_list', 'description' => 'Visualizar Registro - Alimentação Planos']);
        Permissao::create(['id' => 94, 'submodulo_id' => 20, 'name' => 'alimentacao_planos_create', 'description' => 'Criar Registro - Alimentação Planos']);
        Permissao::create(['id' => 95, 'submodulo_id' => 20, 'name' => 'alimentacao_planos_show', 'description' => 'Visualizar Registro - Alimentação Planos']);
        Permissao::create(['id' => 96, 'submodulo_id' => 20, 'name' => 'alimentacao_planos_edit', 'description' => 'Editar Registro - Alimentação Planos']);
        Permissao::create(['id' => 97, 'submodulo_id' => 20, 'name' => 'alimentacao_planos_destroy', 'description' => 'Deletar Registro - Alimentação Planos']);

        Permissao::create(['id' => 98, 'submodulo_id' => 21, 'name' => 'alimentacao_unidades_list', 'description' => 'Visualizar Registro - Alimentação Unidades']);
        Permissao::create(['id' => 99, 'submodulo_id' => 21, 'name' => 'alimentacao_unidades_create', 'description' => 'Criar Registro - Alimentação Unidades']);
        Permissao::create(['id' => 100, 'submodulo_id' => 21, 'name' => 'alimentacao_unidades_show', 'description' => 'Visualizar Registro - Alimentação Unidades']);
        Permissao::create(['id' => 101, 'submodulo_id' => 21, 'name' => 'alimentacao_unidades_edit', 'description' => 'Editar Registro - Alimentação Unidades']);
        Permissao::create(['id' => 102, 'submodulo_id' => 21, 'name' => 'alimentacao_unidades_destroy', 'description' => 'Deletar Registro - Alimentação Unidades']);

        Permissao::create(['id' => 103, 'submodulo_id' => 22, 'name' => 'alimentacao_remanejamentos_list', 'description' => 'Visualizar Registro - Alimentação Remanejamentos']);
        Permissao::create(['id' => 104, 'submodulo_id' => 22, 'name' => 'alimentacao_remanejamentos_create', 'description' => 'Criar Registro - Alimentação Remanejamentos']);
        Permissao::create(['id' => 105, 'submodulo_id' => 22, 'name' => 'alimentacao_remanejamentos_show', 'description' => 'Visualizar Registro - Alimentação Remanejamentos']);
        Permissao::create(['id' => 106, 'submodulo_id' => 22, 'name' => 'alimentacao_remanejamentos_edit', 'description' => 'Editar Registro - Alimentação Remanejamentos']);
        Permissao::create(['id' => 107, 'submodulo_id' => 22, 'name' => 'alimentacao_remanejamentos_destroy', 'description' => 'Deletar Registro - Alimentação Remanejamentos']);

        Permissao::create(['id' => 108, 'submodulo_id' => 23, 'name' => 'alimentacao_quantitativos_list', 'description' => 'Visualizar Registro - Alimentação Quantitativos']);
        Permissao::create(['id' => 109, 'submodulo_id' => 23, 'name' => 'alimentacao_quantitativos_create', 'description' => 'Criar Registro - Alimentação Quantitativos']);
        Permissao::create(['id' => 110, 'submodulo_id' => 23, 'name' => 'alimentacao_quantitativos_show', 'description' => 'Visualizar Registro - Alimentação Quantitativos']);
        Permissao::create(['id' => 111, 'submodulo_id' => 23, 'name' => 'alimentacao_quantitativos_edit', 'description' => 'Editar Registro - Alimentação Quantitativos']);
        Permissao::create(['id' => 112, 'submodulo_id' => 23, 'name' => 'alimentacao_quantitativos_destroy', 'description' => 'Deletar Registro - Alimentação Quantitativos']);

        Permissao::create(['id' => 113, 'submodulo_id' => 24, 'name' => 'sad_militares_informacoes_list', 'description' => 'Visualizar Registro']);
        Permissao::create(['id' => 114, 'submodulo_id' => 24, 'name' => 'sad_militares_informacoes_create', 'description' => 'Criar Registro']);
        Permissao::create(['id' => 115, 'submodulo_id' => 24, 'name' => 'sad_militares_informacoes_show', 'description' => 'Visualizar Registro']);
        Permissao::create(['id' => 116, 'submodulo_id' => 24, 'name' => 'sad_militares_informacoes_edit', 'description' => 'Editar Registro']);
        Permissao::create(['id' => 117, 'submodulo_id' => 24, 'name' => 'sad_militares_informacoes_destroy', 'description' => 'Deletar Registro']);
    }
}
