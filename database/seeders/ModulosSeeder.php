<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulosSeeder extends Seeder
{
    public function run()
    {
        DB::table('modulos')->insert([
            //Geral
            ['id' => '1', 'setor_id' => null, 'name' => 'Home', 'menu_text' => 'Home', 'menu_url' => 'home', 'menu_route' => 'home', 'menu_icon' => 'fa fa-home', 'ordem_visualizacao' => 10],
            ['id' => '2', 'setor_id' => null, 'name' => 'Auxiliares', 'menu_text' => 'Auxiliares', 'menu_url' => 'auxiliares', 'menu_route' => 'auxiliares', 'menu_icon' => 'fa fa-list', 'ordem_visualizacao' => 40],
            ['id' => '5', 'setor_id' => null, 'name' => 'Efetivo', 'menu_text' => 'Efetivo', 'menu_url' => 'efetivo', 'menu_route' => 'efetivo', 'menu_icon' => 'fa fa-users', 'ordem_visualizacao' => 20],
	 		['id' => '4', 'setor_id' => null, 'name' => 'Relatórios', 'menu_text' => 'Relatórios', 'menu_url' => 'relatorios', 'menu_route' => 'relatorios', 'menu_icon' => 'fa fa-print', 'ordem_visualizacao' => 7777],

            //DGF/1

            //DGF/2
            ['id' => '3', 'setor_id' => 2, 'name' => 'Ressarcimento', 'menu_text' => 'Ressarcimento', 'menu_url' => 'ressarcimentos', 'menu_route' => 'ressarcimentos', 'menu_icon' => 'fas fa-file-invoice-dollar', 'ordem_visualizacao' => 30],

            //DGF/3

            //DGF/4

            //Pagadoria
            ['id' => '6', 'setor_id' => 5, 'name' => 'Alimentação', 'menu_text' => 'Alimentação', 'menu_url' => 'alimentacao', 'menu_route' => 'alimentacao', 'menu_icon' => 'fa fa-coffee', 'ordem_visualizacao' => 10],

            //Diretoria

            //SAD
            ['id' => '7', 'setor_id' => 7, 'name' => 'Militares', 'menu_text' => 'Militares', 'menu_url' => 'sad_militares', 'menu_route' => 'sad_militares', 'menu_icon' => 'fa fa-users', 'ordem_visualizacao' => 10],
        ]);
    }
}
