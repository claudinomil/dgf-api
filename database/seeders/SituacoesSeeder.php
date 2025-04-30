<?php

namespace Database\Seeders;

use App\Models\Situacao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SituacoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Situacao::create(['name' => 'Liberado', 'bg_badge' => 'success']);
        Situacao::create(['name' => 'Bloqueado', 'bg_badge' => 'danger']);
    }
}
