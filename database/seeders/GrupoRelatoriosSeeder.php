<?php

namespace Database\Seeders;

use App\Models\GrupoRelatorio;
use Illuminate\Database\Seeder;

class GrupoRelatoriosSeeder extends Seeder
{
    public function run()
    {
        //grupo_id=1
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 1]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 2]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 3]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 4]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 5]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 6]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 7]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 8]);

        //grupo_id=2
        GrupoRelatorio::create(['grupo_id' => 2, 'relatorio_id' => 1]);
        GrupoRelatorio::create(['grupo_id' => 2, 'relatorio_id' => 2]);
        GrupoRelatorio::create(['grupo_id' => 2, 'relatorio_id' => 3]);
        GrupoRelatorio::create(['grupo_id' => 2, 'relatorio_id' => 4]);
        GrupoRelatorio::create(['grupo_id' => 2, 'relatorio_id' => 5]);

        //grupo_id=3
        GrupoRelatorio::create(['grupo_id' => 3, 'relatorio_id' => 1]);
        GrupoRelatorio::create(['grupo_id' => 3, 'relatorio_id' => 2]);
        GrupoRelatorio::create(['grupo_id' => 3, 'relatorio_id' => 3]);
        GrupoRelatorio::create(['grupo_id' => 3, 'relatorio_id' => 4]);
        GrupoRelatorio::create(['grupo_id' => 3, 'relatorio_id' => 5]);

        //grupo_id=4
        GrupoRelatorio::create(['grupo_id' => 4, 'relatorio_id' => 1]);
        GrupoRelatorio::create(['grupo_id' => 4, 'relatorio_id' => 2]);
        GrupoRelatorio::create(['grupo_id' => 4, 'relatorio_id' => 3]);
        GrupoRelatorio::create(['grupo_id' => 4, 'relatorio_id' => 4]);
        GrupoRelatorio::create(['grupo_id' => 4, 'relatorio_id' => 5]);

        //grupo_id=5
        GrupoRelatorio::create(['grupo_id' => 5, 'relatorio_id' => 1]);
        GrupoRelatorio::create(['grupo_id' => 5, 'relatorio_id' => 2]);
        GrupoRelatorio::create(['grupo_id' => 5, 'relatorio_id' => 3]);
        GrupoRelatorio::create(['grupo_id' => 5, 'relatorio_id' => 4]);
        GrupoRelatorio::create(['grupo_id' => 5, 'relatorio_id' => 5]);

        //grupo_id=6
        GrupoRelatorio::create(['grupo_id' => 6, 'relatorio_id' => 1]);
        GrupoRelatorio::create(['grupo_id' => 6, 'relatorio_id' => 2]);
        GrupoRelatorio::create(['grupo_id' => 6, 'relatorio_id' => 3]);
        GrupoRelatorio::create(['grupo_id' => 6, 'relatorio_id' => 4]);
        GrupoRelatorio::create(['grupo_id' => 6, 'relatorio_id' => 5]);
    }
}
