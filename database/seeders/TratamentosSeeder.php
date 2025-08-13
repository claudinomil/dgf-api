<?php

namespace Database\Seeders;

use App\Models\Tratamento;
use Illuminate\Database\Seeder;

class TratamentosSeeder extends Seeder
{
    public function run()
    {
        Tratamento::create(['id' => '1', 'completo' => 'Vossa Excelência', 'reduzido' => 'V.Ex.ª', 'ordem_visualizacao' => 10]);
        Tratamento::create(['id' => '2', 'completo' => 'Vossa Senhoria', 'reduzido' => 'V.S.ª', 'ordem_visualizacao' => 20]);
        Tratamento::create(['id' => '3', 'completo' => 'Senhor(a)', 'reduzido' => 'Sr(ª)', 'ordem_visualizacao' => 30]);
    }
}
