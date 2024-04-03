<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDashboardViews;
use App\Models\UserRelatorioViews;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'CLAUDINO MIL HOMENS DE MORAES',
            'email' => 'claudinomoraes@yahoo.com.br',
            'password' => Hash::make('claudino1971'),
            'email_verified_at' => now(),
            'avatar' => 'build/assets/images/users/avatar-0.png',
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable',
            'grupo_id' => '1',
            'situacao_id' => '1',
            'militar_rg' => 27335,
            'militar_nome' => 'CLAUDINO MIL HOMENS DE MORAES',
            'militar_posto_graduacao_ordem' => 13,
            'militar_posto_graduacao' => '1º SARGENTO',
            'created_at' => now()
        ]);

        //Dashboards que o Usuário vai ver inicialmente
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 1, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 2, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 3, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 4, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 5, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 6, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 7, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 8, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 9, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 10, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 11, 'largura' => 12, 'ordem_visualizacao' => 6]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 12, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 13, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 14, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 15, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 16, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 1, 'dashboard_id' => 17, 'largura' => 6, 'ordem_visualizacao' => 6]);

        //Relatórios que o Usuário vai ver inicialmente
        UserRelatorioViews::create(['user_id' => 1, 'relatorio_id' => 1, 'ordem_visualizacao' => 1]);
        UserRelatorioViews::create(['user_id' => 1, 'relatorio_id' => 2, 'ordem_visualizacao' => 1]);
        UserRelatorioViews::create(['user_id' => 1, 'relatorio_id' => 3, 'ordem_visualizacao' => 1]);
        UserRelatorioViews::create(['user_id' => 1, 'relatorio_id' => 4, 'ordem_visualizacao' => 1]);
        UserRelatorioViews::create(['user_id' => 1, 'relatorio_id' => 5, 'ordem_visualizacao' => 1]);
        UserRelatorioViews::create(['user_id' => 1, 'relatorio_id' => 6, 'ordem_visualizacao' => 1]);
        UserRelatorioViews::create(['user_id' => 1, 'relatorio_id' => 7, 'ordem_visualizacao' => 1]);
        UserRelatorioViews::create(['user_id' => 1, 'relatorio_id' => 8, 'ordem_visualizacao' => 1]);
    }
}
