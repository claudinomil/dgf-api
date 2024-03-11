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

        UserDashboardViews::create(['user_id' => 1, 'grupo_dashboard_id' => 1, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'grupo_dashboard_id' => 2, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'grupo_dashboard_id' => 3, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'grupo_dashboard_id' => 4, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'grupo_dashboard_id' => 5, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'grupo_dashboard_id' => 6, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'grupo_dashboard_id' => 7, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'grupo_dashboard_id' => 8, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'grupo_dashboard_id' => 9, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'grupo_dashboard_id' => 10, 'ordem_visualizacao' => 1]);
        UserDashboardViews::create(['user_id' => 1, 'grupo_dashboard_id' => 11, 'ordem_visualizacao' => 1]);
    }
}
