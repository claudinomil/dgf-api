<?php

namespace Database\Seeders;

use App\Models\Esfera;
use Illuminate\Database\Seeder;

class EsferasSeeder extends Seeder
{
    public function run()
    {
        Esfera::create(['id' => '1', 'name' => 'UNIÃO', 'viewing_order' => 10]);
        Esfera::create(['id' => '2', 'name' => 'ESTADOS', 'viewing_order' => 20]);
        Esfera::create(['id' => '3', 'name' => 'MUNICÍPIOS', 'viewing_order' => 30]);
    }
}
