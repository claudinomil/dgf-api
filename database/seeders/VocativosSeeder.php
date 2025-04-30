<?php

namespace Database\Seeders;

use App\Models\Vocativo;
use Illuminate\Database\Seeder;

class VocativosSeeder extends Seeder
{
    public function run()
    {
        Vocativo::create(['id' => '1', 'name' => 'Xxxxxxx', 'ordem_visualizacao' => 0]);
        Vocativo::create(['id' => '2', 'name' => 'Yyyyyyy', 'ordem_visualizacao' => 0]);

    }
}
