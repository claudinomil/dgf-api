<?php

namespace Database\Seeders;

use App\Models\Tratamento;
use Illuminate\Database\Seeder;

class TratamentosSeeder extends Seeder
{
    public function run()
    {
        Tratamento::create(['id' => '1', 'completo' => 'Vossa Excelência', 'reduzido' => 'V.Ex.ª', 'viewing_order' => 10]);
        Tratamento::create(['id' => '2', 'completo' => 'Vossa Senhoria', 'reduzido' => 'V.S.ª', 'viewing_order' => 20]);
    }
}
