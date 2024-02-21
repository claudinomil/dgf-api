<?php

namespace Database\Seeders;

use App\Models\Poder;
use Illuminate\Database\Seeder;

class PoderesSeeder extends Seeder
{
    public function run()
    {
        Poder::create(['id' => '1', 'name' => 'PODER EXECUTIVO', 'viewing_order' => 10]);
        Poder::create(['id' => '2', 'name' => 'PODER LEGISLATIVO', 'viewing_order' => 20]);
        Poder::create(['id' => '3', 'name' => 'PODER JUDICIÁRIO', 'viewing_order' => 30]);
    }
}
