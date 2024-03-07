<?php

namespace Database\Seeders;

use App\Models\Transacao;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Z_FakerSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        $grupo_id_max = 6;
        $user_id_max = 1;

//        //Criando Grupo
//        for($i=1; $i<=10; $i++) {
//            $grupo = Grupo::create(['name' => 'Grupo ' . $i]);
//            $grupo_id = $grupo['id'];
//            $grupo_id_max = $grupo['id'];
//        }
//
//        //Criando Grupo Permissões
//        GrupoPermissao::create(['grupo_id' => $grupo_id, 'permissao_id' => 1]);

        //Criando Usuários
        for($i=1; $i<=50; $i++) {
            $militar_posto_graduacao = $faker->randomElement(['SOLDADO', 'CABO', '3º SARGENTO', '2º SARGENTO', '1º SARGENTO', 'SUBTENENTE', '2º TENENTE', '1º TENENTE', 'CAPITÃO', 'MAJOR', 'TENENTE CORONEL', 'CORONEL']);

            if ($militar_posto_graduacao == 'NATUREZA CIVIL') {$militar_posto_graduacao_ordem = 1;}
            if ($militar_posto_graduacao == 'CORONEL') {$militar_posto_graduacao_ordem = 2;}
            if ($militar_posto_graduacao == 'TENENTE CORONEL') {$militar_posto_graduacao_ordem = 3;}
            if ($militar_posto_graduacao == 'MAJOR') {$militar_posto_graduacao_ordem = 4;}
            if ($militar_posto_graduacao == 'CAPITÃO') {$militar_posto_graduacao_ordem = 5;}
            if ($militar_posto_graduacao == '1º TENENTE') {$militar_posto_graduacao_ordem = 6;}
            if ($militar_posto_graduacao == '2º TENENTE') {$militar_posto_graduacao_ordem = 7;}
            if ($militar_posto_graduacao == 'ASPIRANTE') {$militar_posto_graduacao_ordem = 8;}
            if ($militar_posto_graduacao == 'CADETE DO 3º ANO') {$militar_posto_graduacao_ordem = 9;}
            if ($militar_posto_graduacao == 'CADETE DO 2º ANO') {$militar_posto_graduacao_ordem = 10;}
            if ($militar_posto_graduacao == 'CADETE DO 1º ANO') {$militar_posto_graduacao_ordem = 11;}
            if ($militar_posto_graduacao == 'SUBTENENTE') {$militar_posto_graduacao_ordem = 12;}
            if ($militar_posto_graduacao == '1º SARGENTO') {$militar_posto_graduacao_ordem = 13;}
            if ($militar_posto_graduacao == '2º SARGENTO') {$militar_posto_graduacao_ordem = 14;}
            if ($militar_posto_graduacao == '3º SARGENTO') {$militar_posto_graduacao_ordem = 15;}
            if ($militar_posto_graduacao == 'CABO') {$militar_posto_graduacao_ordem = 16;}
            if ($militar_posto_graduacao == 'SOLDADO') {$militar_posto_graduacao_ordem = 17;}
            if ($militar_posto_graduacao == 'SOLDADO RECRUTA') {$militar_posto_graduacao_ordem = 18;}
            if ($militar_posto_graduacao == 'PENSIONISTA') {$militar_posto_graduacao_ordem = 19;}

            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('claudino1971'),
                'email_verified_at' => now(),
                'avatar' => 'build/assets/images/users/avatar-0.png',
                'layout_mode' => 'layout_mode_light',
                'layout_style' => 'layout_style_vertical_scrollable',
                'grupo_id' => $faker->numberBetween(1, $grupo_id_max),
                'situacao_id' => $faker->numberBetween(1, 2),
                'militar_rg' => $faker->numberBetween(27200, 27900),
                'militar_nome' => $faker->name,
                'militar_posto_graduacao_ordem' => $militar_posto_graduacao_ordem,
                'militar_posto_graduacao' => $militar_posto_graduacao,
                'created_at' => now()
            ]);

            $user_id_max = $user['id'];
        }

        //Criando Transações
        for($i=1; $i<=500; $i++) {
            Transacao::create([
                'date' => $faker->date,
                'time' => $faker->time,
                'user_id' => $faker->numberBetween(1, $user_id_max),
                'operacao_id' => $faker->numberBetween(1, 3),
                'submodulo_id' => $faker->numberBetween(1, 15),
                'dados' => 'Criado pelo arquivo Z_FakerSeeder.php'
            ]);
        }
    }
}
