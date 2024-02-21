<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulosSeeder extends Seeder
{
    public function run()
    {
        DB::table('modulos')->insert([
            ['id' => '1', 'name' => 'Home', 'menu_text' => 'Home', 'menu_url' => 'home', 'menu_route' => 'home', 'menu_icon' => 'fa fa-home', 'viewing_order' => 10],
            ['id' => '2', 'name' => 'Auxiliares', 'menu_text' => 'Auxiliares', 'menu_url' => 'auxiliares', 'menu_route' => 'auxiliares', 'menu_icon' => 'fa fa-list', 'viewing_order' => 40],
            ['id' => '3', 'name' => 'Ressarcimento', 'menu_text' => 'Ressarcimento', 'menu_url' => 'ressarcimentos', 'menu_route' => 'ressarcimentos', 'menu_icon' => 'fa fa-star', 'viewing_order' => 30],
            ['id' => '5', 'name' => 'Efetivo', 'menu_text' => 'Efetivo', 'menu_url' => 'efetivo', 'menu_route' => 'efetivo', 'menu_icon' => 'fa fa-users', 'viewing_order' => 20],
	 		['id' => '4', 'name' => 'Relatórios', 'menu_text' => 'Relatórios', 'menu_url' => 'relatorios', 'menu_route' => 'relatorios', 'menu_icon' => 'fa fa-print', 'viewing_order' => 7777]
        ]);
    }
}
