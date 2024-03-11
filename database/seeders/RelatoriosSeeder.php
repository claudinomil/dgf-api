<?php

namespace Database\Seeders;

use App\Models\Relatorio;
use Illuminate\Database\Seeder;

class RelatoriosSeeder extends Seeder
{
    public function run()
    {
        //modulo_id=1 : Home
        Relatorio::create(['id' => 1, 'modulo_id' => 1, 'name' => 'Grupos', 'descricao' => '', 'ordem_visualizacao' => 1]);
        Relatorio::create(['id' => 2, 'modulo_id' => 1, 'name' => 'Usuários', 'descricao' => '', 'ordem_visualizacao' => 2]);
        Relatorio::create(['id' => 3, 'modulo_id' => 1, 'name' => 'Log de Transações', 'descricao' => '', 'ordem_visualizacao' => 3]);
        Relatorio::create(['id' => 4, 'modulo_id' => 1, 'name' => 'Notificações', 'descricao' => '', 'ordem_visualizacao' => 4]);
        Relatorio::create(['id' => 5, 'modulo_id' => 1, 'name' => 'Ferramentas', 'descricao' => '', 'ordem_visualizacao' => 5]);

        //modulo_id=3 : Ressarcimento
        Relatorio::create(['id' => 6, 'modulo_id' => 3, 'name' => 'Militares por Referência e Órgão(s)', 'descricao' => '', 'ordem_visualizacao' => 1]);
        Relatorio::create(['id' => 7, 'modulo_id' => 3, 'name' => 'Ressarcimento por Referência e Órgão(s)', 'descricao' => '', 'ordem_visualizacao' => 2]);
        Relatorio::create(['id' => 8, 'modulo_id' => 3, 'name' => 'Dívidas do(s) Órgão(s)', 'descricao' => '', 'ordem_visualizacao' => 3]);
        Relatorio::create(['id' => 9, 'modulo_id' => 3, 'name' => 'Ressarcimento Relatório 4', 'descricao' => '', 'ordem_visualizacao' => 4]);
        Relatorio::create(['id' => 10, 'modulo_id' => 3, 'name' => 'Ressarcimento Relatório 5', 'descricao' => '', 'ordem_visualizacao' => 5]);
    }
}
