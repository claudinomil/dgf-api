<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            SetoresSeeder::class,
            ModulosSeeder::class,
            SubmodulosSeeder::class,
            AgrupamentosSeeder::class,
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
            UserSeeder::class,
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
