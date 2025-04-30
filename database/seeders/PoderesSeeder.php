<?php

namespace Database\Seeders;

use App\Models\Poder;
use Illuminate\Database\Seeder;

class PoderesSeeder extends Seeder
{
    public function run()
    {
        Poder::create(['id' => '1', 'name' => 'PODER EXECUTIVO', 'ordem_visualizacao' => 10]);
        Poder::create(['id' => '2', 'name' => 'PODER LEGISLATIVO', 'ordem_visualizacao' => 20]);
        Poder::create(['id' => '3', 'name' => 'PODER JUDICIÁRIO', 'ordem_visualizacao' => 30]);
    }
}
