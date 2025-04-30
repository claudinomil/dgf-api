<?php

namespace Database\Seeders;

use App\Models\LayoutMode;
use Illuminate\Database\Seeder;

class LayoutsModesSeeder extends Seeder
{
    public function run()
    {
        LayoutMode::create(['id' => 1, 'name' => 'layout_mode_light', 'descricao' => 'Modo Claro', 'ativo' => 1]);
        LayoutMode::create(['id' => 2, 'name' => 'layout_mode_dark', 'descricao' => 'Modo Escuro', 'ativo' => 1]);
    }
}
