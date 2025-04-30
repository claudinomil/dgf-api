<?php

namespace Database\Seeders;

use App\Models\Relatorio;
use Illuminate\Database\Seeder;

class RelatoriosSeeder extends Seeder
{
    public function run()
    {
        //agrupamento_id=1 : Cadastros
        Relatorio::create(['id' => 1, 'agrupamento_id' => 1, 'name' => 'Grupos', 'descricao' => '', 'ordem_visualizacao' => 1]);
        Relatorio::create(['id' => 2, 'agrupamento_id' => 1, 'name' => 'Usuários', 'descricao' => '', 'ordem_visualizacao' => 2]);
        Relatorio::create(['id' => 3, 'agrupamento_id' => 1, 'name' => 'Log de Transações', 'descricao' => '', 'ordem_visualizacao' => 3]);
        Relatorio::create(['id' => 4, 'agrupamento_id' => 1, 'name' => 'Notificações', 'descricao' => '', 'ordem_visualizacao' => 4]);
        Relatorio::create(['id' => 5, 'agrupamento_id' => 1, 'name' => 'Ferramentas', 'descricao' => '', 'ordem_visualizacao' => 5]);

        //agrupamento_id=2 : Ressarcimentos
        Relatorio::create(['id' => 6, 'agrupamento_id' => 2, 'name' => 'Militares por Referência e Órgão(s)', 'descricao' => '', 'ordem_visualizacao' => 1]);
        Relatorio::create(['id' => 7, 'agrupamento_id' => 2, 'name' => 'Ressarcimento por Referência e Órgão(s)', 'descricao' => '', 'ordem_visualizacao' => 2]);
        Relatorio::create(['id' => 8, 'agrupamento_id' => 2, 'name' => 'Dívidas do(s) Órgão(s)', 'descricao' => '', 'ordem_visualizacao' => 3]);
    }
}
