<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ModulosSeeder::class,
            SubmodulosSeeder::class,
            DashboardsSeeder::class,
            RelatoriosSeeder::class,
            GruposSeeder::class,
            IconsSeeder::class,
            PermissoesSeeder::class,
            GrupoPermissoesSeeder::class,
            GrupoDashboardsSeeder::class,
            GrupoRelatoriosSeeder::class,
            SituacoesSeeder::class,
            OperacoesSeeder::class,
            UsersSeeder::class,
            EsferasSeeder::class,
            FuncoesSeeder::class,
            PoderesSeeder::class,
            TratamentosSeeder::class,
            VocativosSeeder::class,
            LayoutsStylesSeeder::class,
            LayoutsModesSeeder::class
        ]);
    }
}
