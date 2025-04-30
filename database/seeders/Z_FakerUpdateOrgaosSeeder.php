<?php

namespace Database\Seeders;

use App\Models\RessarcimentoOrgao;
use Illuminate\Database\Seeder;

class Z_FakerUpdateOrgaosSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        $orgaos = RessarcimentoOrgao::all();

        foreach ($orgaos as $orgao) {
            $reg = RessarcimentoOrgao::where('id', $orgao['id']);
            $reg->update([
                //'name' => $faker->name,
                'ug' => '11111',
                'esfera_id' => $faker->numberBetween(1, 2),
                'poder_id' => $faker->numberBetween(1, 2),
                'tratamento_id' => $faker->numberBetween(1, 2),
                'vocativo_id' => $faker->numberBetween(1, 2),
                'funcao_id' => $faker->numberBetween(1, 2),
                'cep' => '20710130',
                'numero' => $faker->numberBetween(1, 20000)
            ]);
        }
    }
}
