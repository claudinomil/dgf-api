<?php

namespace Database\Seeders;

use App\Models\Operacao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperacoesSeeder extends Seeder
{
    public function run()
    {
        Operacao::create(['name' => 'Inclusão']);
        Operacao::create(['name' => 'Alteração']);
        Operacao::create(['name' => 'Exclusão']);
    }
}
