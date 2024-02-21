<?php

namespace Database\Seeders;

use App\Models\Vocativo;
use Illuminate\Database\Seeder;

class VocativosSeeder extends Seeder
{
    public function run()
    {
        Vocativo::create(['id' => '1', 'name' => 'Xxxxxxx', 'viewing_order' => 0]);
        Vocativo::create(['id' => '2', 'name' => 'Yyyyyyy', 'viewing_order' => 0]);

    }
}
