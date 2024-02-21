<?php

namespace Database\Seeders;

use App\Models\Funcao;
use Illuminate\Database\Seeder;

class FuncoesSeeder extends Seeder
{
    public function run()
    {
        Funcao::create(['id' => '1', 'name' => 'COMANDANTE', 'viewing_order' => 10]);
        Funcao::create(['id' => '2', 'name' => 'DIRETOR', 'viewing_order' => 20]);
        Funcao::create(['id' => '3', 'name' => 'CHEFE', 'viewing_order' => 30]);
    }
}
