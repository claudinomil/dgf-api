<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Seeder;

class GruposSeeder extends Seeder
{
    public function run()
    {
        Grupo::create(['id' => 1, 'name' => 'Administrador Geral']);
        Grupo::create(['id' => 2, 'name' => 'Administrador DGF 1']);
        Grupo::create(['id' => 3, 'name' => 'Administrador DGF 2']);
        Grupo::create(['id' => 4, 'name' => 'Administrador DGF 3']);
        Grupo::create(['id' => 5, 'name' => 'Administrador DGF 4']);
        Grupo::create(['id' => 6, 'name' => 'Administrador Pagadoria']);
    }
}
