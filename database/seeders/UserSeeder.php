<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDashboardViews;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        //Criando Usuário'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        User::create([
            'id' => 1,
            'name' => 'CLAUDINO MIL HOMENS DE MORAES',
            'email' => 'claudinomoraes@yahoo.com.br',
            'password' => Hash::make('claudino1971'),
            'email_verified_at' => now(),
            'user_confirmed_at' => now(),
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
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Criando Usuário'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        User::create([
            'id' => 2,
            'name' => 'EDUARDO FERREIRA GONCALVES',
            'email' => 'eduardoferreira@ycbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'user_confirmed_at' => now(),
            'avatar' => 'build/assets/images/users/avatar-0.png',
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable',
            'grupo_id' => '1',
            'situacao_id' => '1',
            'militar_rg' => 36604,
            'militar_nome' => 'EDUARDO FERREIRA GONCALVES',
            'militar_posto_graduacao_ordem' => 4,
            'militar_posto_graduacao' => 'MAJOR',
            'created_at' => now()
        ]);

        //Dashboards que o Usuário vai ver inicialmente
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 1, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 2, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 3, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 4, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 5, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 6, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 7, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 8, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 9, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 10, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 11, 'largura' => 12, 'ordem_visualizacao' => 6]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 12, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 13, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 14, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 15, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 16, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 2, 'dashboard_id' => 17, 'largura' => 6, 'ordem_visualizacao' => 6]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Criando Usuário'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        User::create([
            'id' => 3,
            'name' => 'CAIO GUEDES DA SILVA',
            'email' => 'caioguedes@ycbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'user_confirmed_at' => now(),
            'avatar' => 'build/assets/images/users/avatar-0.png',
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable',
            'grupo_id' => '1',
            'situacao_id' => '1',
            'militar_rg' => 46082,
            'militar_nome' => 'CAIO GUEDES DA SILVA',
            'militar_posto_graduacao_ordem' => 5,
            'militar_posto_graduacao' => 'CAPITÃO',
            'created_at' => now()
        ]);

        //Dashboards que o Usuário vai ver inicialmente
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 1, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 2, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 3, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 4, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 5, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 6, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 7, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 8, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 9, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 10, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 11, 'largura' => 12, 'ordem_visualizacao' => 6]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 12, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 13, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 14, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 15, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 16, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 3, 'dashboard_id' => 17, 'largura' => 6, 'ordem_visualizacao' => 6]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Criando Usuário'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        User::create([
            'id' => 4,
            'name' => 'WILLIAN GUEDES DA SILVA',
            'email' => 'willianguedes@ycbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'user_confirmed_at' => now(),
            'avatar' => 'build/assets/images/users/avatar-0.png',
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable',
            'grupo_id' => '1',
            'situacao_id' => '1',
            'militar_rg' => 46085,
            'militar_nome' => 'WILLIAN GUEDES DA SILVA',
            'militar_posto_graduacao_ordem' => 5,
            'militar_posto_graduacao' => 'CAPITÃO',
            'created_at' => now()
        ]);

        //Dashboards que o Usuário vai ver inicialmente
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 1, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 2, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 3, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 4, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 5, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 6, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 7, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 8, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 9, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 10, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 11, 'largura' => 12, 'ordem_visualizacao' => 6]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 12, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 13, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 14, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 15, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 16, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 4, 'dashboard_id' => 17, 'largura' => 6, 'ordem_visualizacao' => 6]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Criando Usuário'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        User::create([
            'id' => 5,
            'name' => 'MONIQUE MAIA SILVA',
            'email' => 'moniquemaia@ycbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'user_confirmed_at' => now(),
            'avatar' => 'build/assets/images/users/avatar-0.png',
            'layout_mode' => 'layout_mode_light',
            'layout_style' => 'layout_style_vertical_scrollable',
            'grupo_id' => '1',
            'situacao_id' => '1',
            'militar_rg' => 27940,
            'militar_nome' => 'MONIQUE MAIA SILVA',
            'militar_posto_graduacao_ordem' => 12,
            'militar_posto_graduacao' => 'SUBTENENTE',
            'created_at' => now()
        ]);

        //Dashboards que o Usuário vai ver inicialmente
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 1, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 2, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 3, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 4, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 5, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 6, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 7, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 8, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 9, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 10, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 11, 'largura' => 12, 'ordem_visualizacao' => 6]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 12, 'largura' => 12, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 13, 'largura' => 6, 'ordem_visualizacao' => 2]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 14, 'largura' => 6, 'ordem_visualizacao' => 3]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 15, 'largura' => 6, 'ordem_visualizacao' => 4]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 16, 'largura' => 6, 'ordem_visualizacao' => 5]);
        UserDashboardViews::create(['user_id' => 5, 'dashboard_id' => 17, 'largura' => 6, 'ordem_visualizacao' => 6]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
