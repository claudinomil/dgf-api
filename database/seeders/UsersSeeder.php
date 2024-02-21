<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
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
    }
}
