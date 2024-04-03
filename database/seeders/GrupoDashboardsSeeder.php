<?php

namespace Database\Seeders;

use App\Models\GrupoDashboard;
use Illuminate\Database\Seeder;

class GrupoDashboardsSeeder extends Seeder
{
    public function run()
    {
        //grupo_id=1
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 1]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 2]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 3]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 4]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 5]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 6]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 7]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 8]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 9]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 10]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 11]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 12]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 13]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 14]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 15]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 16]);
        GrupoDashboard::create(['grupo_id' => 1, 'dashboard_id' => 17]);

        //grupo_id=2
        GrupoDashboard::create(['grupo_id' => 2, 'dashboard_id' => 1]);
        GrupoDashboard::create(['grupo_id' => 2, 'dashboard_id' => 2]);
        GrupoDashboard::create(['grupo_id' => 2, 'dashboard_id' => 3]);
        GrupoDashboard::create(['grupo_id' => 2, 'dashboard_id' => 4]);
        GrupoDashboard::create(['grupo_id' => 2, 'dashboard_id' => 5]);

        //grupo_id=3
        GrupoDashboard::create(['grupo_id' => 3, 'dashboard_id' => 1]);
        GrupoDashboard::create(['grupo_id' => 3, 'dashboard_id' => 2]);
        GrupoDashboard::create(['grupo_id' => 3, 'dashboard_id' => 3]);
        GrupoDashboard::create(['grupo_id' => 3, 'dashboard_id' => 4]);
        GrupoDashboard::create(['grupo_id' => 3, 'dashboard_id' => 5]);

        //grupo_id=4
        GrupoDashboard::create(['grupo_id' => 4, 'dashboard_id' => 1]);
        GrupoDashboard::create(['grupo_id' => 4, 'dashboard_id' => 2]);
        GrupoDashboard::create(['grupo_id' => 4, 'dashboard_id' => 3]);
        GrupoDashboard::create(['grupo_id' => 4, 'dashboard_id' => 4]);
        GrupoDashboard::create(['grupo_id' => 4, 'dashboard_id' => 5]);

        //grupo_id=5
        GrupoDashboard::create(['grupo_id' => 5, 'dashboard_id' => 1]);
        GrupoDashboard::create(['grupo_id' => 5, 'dashboard_id' => 2]);
        GrupoDashboard::create(['grupo_id' => 5, 'dashboard_id' => 3]);
        GrupoDashboard::create(['grupo_id' => 5, 'dashboard_id' => 4]);
        GrupoDashboard::create(['grupo_id' => 5, 'dashboard_id' => 5]);

        //grupo_id=6
        GrupoDashboard::create(['grupo_id' => 6, 'dashboard_id' => 1]);
        GrupoDashboard::create(['grupo_id' => 6, 'dashboard_id' => 2]);
        GrupoDashboard::create(['grupo_id' => 6, 'dashboard_id' => 3]);
        GrupoDashboard::create(['grupo_id' => 6, 'dashboard_id' => 4]);
        GrupoDashboard::create(['grupo_id' => 6, 'dashboard_id' => 5]);
    }
}
