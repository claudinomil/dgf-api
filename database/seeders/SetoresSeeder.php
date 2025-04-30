<?php

namespace Database\Seeders;

use App\Models\Setor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetoresSeeder extends Seeder
{
    public function run()
    {
        Setor::create(['id' => 1, 'name' => 'DGF/1', 'menu_icon' => 'fas fa-sign-in-alt', 'ordem_visualizacao' => 2]);
        Setor::create(['id' => 2, 'name' => 'DGF/2', 'menu_icon' => 'fas fa-sign-in-alt', 'ordem_visualizacao' => 3]);
        Setor::create(['id' => 3, 'name' => 'DGF/3', 'menu_icon' => 'fas fa-sign-in-alt', 'ordem_visualizacao' => 4]);
        Setor::create(['id' => 4, 'name' => 'DGF/4', 'menu_icon' => 'fas fa-sign-in-alt', 'ordem_visualizacao' => 5]);
        Setor::create(['id' => 5, 'name' => 'Pagadoria', 'menu_icon' => 'fas fa-sign-in-alt', 'ordem_visualizacao' => 6]);
        Setor::create(['id' => 6, 'name' => 'Diretoria', 'menu_icon' => 'fas fa-sign-in-alt', 'ordem_visualizacao' => 1]);
        Setor::create(['id' => 7, 'name' => 'SAD', 'menu_icon' => 'fas fa-sign-in-alt', 'ordem_visualizacao' => 7]);
    }
}
