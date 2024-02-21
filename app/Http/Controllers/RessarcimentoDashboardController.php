<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Models\Esfera;
use App\Models\GrupoDashboard;
use App\Models\Poder;
use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoOrgao;
use App\Models\RessarcimentoReferencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RessarcimentoDashboardController extends Controller
{
    public function index()
    {
        //Variaveis
        $primeira_referencia = '';
        $ultima_referencia = '';

        //Periodos
        $periodo1 = '';
        $periodo2 = '';

        //Referências
        $referencias = RessarcimentoReferencia::select('referencia')->orderby('referencia', 'DESC')->get();

        $reg = 1;
        foreach ($referencias as $referencia) {
            //Pegando primeira referência
            $primeira_referencia = $referencia['referencia'];

            //Pegando Última referência para servir como referência e periodo 2 para os Gráficos
            if ($reg == 1) {
                $ultima_referencia = $referencia['referencia'];
                $periodo2 = $referencia['referencia'];
            }

            //Pegando referência de 6 meses ou 6 ressarcimentos para trás
            if ($reg == 6) {
                $periodo1 = $referencia['referencia'];
            }

            $reg++;
        }

        if ($periodo1 == '') {$periodo1 = $primeira_referencia;}
        if ($periodo2 == '') {$periodo2 = $ultima_referencia;}

        //Retorno
        $content = array();
        $content['periodo1'] = $periodo1;
        $content['periodo2'] = $periodo2;
        $content['referencias'] = RessarcimentoReferencia::select('referencia')->orderby('referencia', 'DESC')->get();
        $content['orgaos'] = RessarcimentoOrgao::select('id', 'name')->orderby('name', 'ASC')->get();

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $content), 200);
    }

    public function acessos()
    {
        $acessos = GrupoDashboard
            ::join('grupos', 'grupos_dashboards.grupo_id', '=', 'grupos.id')
            ->join('dashboards', 'grupos_dashboards.dashboard_id', '=', 'dashboards.id')
            ->join('modulos', 'modulos.id', '=', 'dashboards.modulo_id')
            ->select('dashboards.id as dashboard_id', 'dashboards.name as dashboard_name', 'dashboards.descricao as dashboard_descricao', 'modulos.name as dashboard_modulo', 'modulos.menu_text as dashboard_modulo', 'modulos.menu_icon as dashboard_icone')
            ->where('grupos_dashboards.grupo_id', Auth::user()->grupo_id)
            ->where('dashboards.modulo_id', 3)
            ->orderBy('dashboards.ordem_visualizacao')
            ->get();

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $acessos), 200);
    }

    public function dashboard6($periodo1, $periodo2, $orgao_id)
    {
        //Array
        $dados = array();

        //Registros Órgãos
        $dados['orgaosQtd'] = RessarcimentoOrgao
            ::join('ressarcimento_militares', 'ressarcimento_militares.lotacao_id', 'ressarcimento_orgaos.lotacao_id')
            ->select('ressarcimento_orgaos.*')
            ->distinct('ressarcimento_orgaos.lotacao_id')
            ->where('ressarcimento_militares.referencia', '>=', $periodo1)
            ->where('ressarcimento_militares.referencia', '<=', $periodo2)
            ->count();

        //Registros Militares
        $dados['militaresQtd'] = RessarcimentoMilitar
            ::where('referencia', '>=', $periodo1)
            ->where('referencia', '<=', $periodo2)
            ->count();

        //Valores Devidos e Pagos
        $valores = RessarcimentoCobrancaDado
            ::join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
            ->join('ressarcimento_pagamentos', 'ressarcimento_pagamentos.id', 'ressarcimento_cobrancas_dados.ressarcimento_pagamento_id')
            ->join('ressarcimento_recebimentos', 'ressarcimento_recebimentos.ressarcimento_cobranca_dado_id', 'ressarcimento_cobrancas_dados.id')
            ->select(DB::raw('SUM(ressarcimento_cobrancas_dados.listagem_valor_total) as valor_ressarcimento'))
            ->where('ressarcimento_cobrancas_dados.referencia', '>=', $periodo1)
            ->where('ressarcimento_cobrancas_dados.referencia', '<=', $periodo2)
            ->groupby('ressarcimento_cobrancas_dados.referencia')
            ->get();

        $valor_ressarcimento = 0;

        foreach ($valores as $valor) {
            $valor_ressarcimento += $valor['valor_ressarcimento'];
        }

        $dados['valorRessarcimento'] = $valor_ressarcimento;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $dados), 200);
    }

    public function dashboard7($periodo1, $periodo2, $orgao_id)
    {
        //Array
        $dados = array();

        //Registros Militares
        $dados['militaresQtd'] = RessarcimentoMilitar
            ::where('referencia', '>=', $periodo1)
            ->where('referencia', '<=', $periodo2)
            ->count();

        //Registros Oficiais
        $dados['oficiaisQtd'] = RessarcimentoMilitar
            ::where('referencia', '>=', $periodo1)
            ->where('referencia', '<=', $periodo2)
            ->where('oficial_praca', 1)
            ->count();

        //Registros Praças
        $dados['pracasQtd'] = RessarcimentoMilitar
            ::where('referencia', '>=', $periodo1)
            ->where('referencia', '<=', $periodo2)
            ->where('oficial_praca', 2)
            ->count();

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $dados), 200);
    }

    public function dashboard8($periodo1, $periodo2, $orgao_id)
    {
        //Array de retorno
        $dados = array();

        //Series
        $series = array();

        $yaxis_max = 0;

        $valores_devidos = 0;
        $valores_pagos = 0;

        $registros = RessarcimentoCobrancaDado
            ::join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
            ->join('ressarcimento_pagamentos', 'ressarcimento_pagamentos.id', 'ressarcimento_cobrancas_dados.ressarcimento_pagamento_id')
            ->join('ressarcimento_recebimentos', 'ressarcimento_recebimentos.ressarcimento_cobranca_dado_id', 'ressarcimento_cobrancas_dados.id')
            ->select(
                'ressarcimento_cobrancas_dados.orgao_name as orgao',
                DB::raw('SUM(ressarcimento_cobrancas_dados.listagem_valor_total) as valor_devido'),
                DB::raw('SUM(ressarcimento_recebimentos.valor_recebido) as valor_pago')
            )
            ->where('ressarcimento_cobrancas_dados.referencia', '>=', $periodo1)
            ->where('ressarcimento_cobrancas_dados.referencia', '<=', $periodo2)
            ->groupby('ressarcimento_cobrancas_dados.orgao_name')
            ->get();

        foreach ($registros as $registro) {
            $valores_devidos = $valores_devidos + $registro['valor_devido'];
            $valores_pagos = $valores_pagos + $registro['valor_pago'];

            if ($valores_devidos > $yaxis_max) {$yaxis_max = $valores_devidos;}
        }

        $series[] = ['name' => 'Valor Devido', 'data' => [number_format($valores_devidos, 2, '.', '')]];
        $series[] = ['name' => 'Valor Pago', 'data' => [number_format($valores_pagos, 2, '.', '')]];

        $dados['series'] = $series;

        //yaxis_max
        $dados['yaxis_max'] = $yaxis_max;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $dados), 200);
    }

    public function dashboard9($periodo1, $periodo2, $orgao_id)
    {
        //Array de retorno
        $dados = array();

        //Series
        $series = array();

        //Cores
        $colors = array();

        //Labels
        $labels = array();

        //Varrer Esperas
        $esferas = Esfera::all();
        foreach ($esferas as $esfera) {
            $qtd = RessarcimentoOrgao
                ::join('ressarcimento_militares', 'ressarcimento_militares.lotacao_id', 'ressarcimento_orgaos.lotacao_id')
                ->select('ressarcimento_orgaos.*')
                ->distinct('ressarcimento_orgaos.lotacao_id')
                ->where('ressarcimento_militares.referencia', '>=', $periodo1)
                ->where('ressarcimento_militares.referencia', '<=', $periodo2)
                ->where('ressarcimento_orgaos.esfera_id', $esfera['id'])
                ->count();

            $series[] = $qtd;
            $labels[] = $esfera['name'];
            $colors[] = SuporteFacade::gerarCorAleatoria();
        }

        $dados['series'] = $series;
        $dados['labels'] = $labels;
        $dados['colors'] = $colors;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $dados), 200);
    }

    public function dashboard10($periodo1, $periodo2, $orgao_id)
    {
        //Array de retorno
        $dados = array();

        //Series
        $series = array();

        //Cores
        $colors = array();

        //Labels
        $labels = array();

        //Varrer Poderes
        $poderes = Poder::all();
        foreach ($poderes as $poder) {
            $qtd = RessarcimentoOrgao
                ::join('ressarcimento_militares', 'ressarcimento_militares.lotacao_id', 'ressarcimento_orgaos.lotacao_id')
                ->select('ressarcimento_orgaos.*')
                ->distinct('ressarcimento_orgaos.lotacao_id')
                ->where('ressarcimento_militares.referencia', '>=', $periodo1)
                ->where('ressarcimento_militares.referencia', '<=', $periodo2)
                ->where('ressarcimento_orgaos.poder_id', $poder['id'])
                ->count();

            $series[] = $qtd;
            $labels[] = $poder['name'];
            $colors[] = SuporteFacade::gerarCorAleatoria();
        }

        $dados['series'] = $series;
        $dados['labels'] = $labels;
        $dados['colors'] = $colors;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $dados), 200);
    }

    public function dashboard11($periodo1, $periodo2, $orgao_id)
    {
        //Arrays
        $dados = array();
        $series = array();
        $colors = array();
        $xaxis_categories = array();
        $valores_devidos = array();
        $valores_pagos = array();

        //Referências
        $ressarcimentoReferencias = RessarcimentoReferencia
            ::where('referencia', '>=', $periodo1)
            ->where('referencia', '<=', $periodo2)
            ->orderby('referencia')
            ->get();

        //Varrer Referências
        foreach ($ressarcimentoReferencias as $ressarcimentoReferencia) {
            //Referência
            $referencia = $ressarcimentoReferencia['referencia'];

            //Legendas para xaxis
            $xaxis_categories[] = SuporteFacade::getMes(3, $ressarcimentoReferencia['mes']).'/'.$ressarcimentoReferencia['ano'].' #'.$ressarcimentoReferencia['parte'];

            //Valor Devido pelo Órgão
            $valores = RessarcimentoCobrancaDado
                ::join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
                ->select('ressarcimento_cobrancas_dados.referencia', DB::raw('SUM(ressarcimento_cobrancas_dados.listagem_valor_total) as valor_devido'))
                ->where(function($query) use($referencia, $orgao_id) {
                    $query->where('ressarcimento_cobrancas_dados.referencia', $referencia);

                    if ($orgao_id != 0) {$query->where('ressarcimento_orgaos.id', $orgao_id);}
                })
                ->groupby('ressarcimento_cobrancas_dados.referencia')
                ->get();

            $val_tot = 0;
            if ($valores->count() > 0) {
                foreach ($valores as $valor) {
                    $val_tot += $valor['valor_devido'];
                }
            }
            $valores_devidos[] = number_format($val_tot, 2, '.', '');

            //Valor Pago pelo Órgão
            $valores = RessarcimentoCobrancaDado
                ::join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
                ->join('ressarcimento_recebimentos', 'ressarcimento_recebimentos.ressarcimento_cobranca_dado_id', 'ressarcimento_cobrancas_dados.id')
                ->select('ressarcimento_cobrancas_dados.referencia', DB::raw('SUM(ressarcimento_recebimentos.valor_recebido) as valor_pago'))
                ->where(function($query) use($referencia, $orgao_id) {
                    $query->where('ressarcimento_cobrancas_dados.referencia', $referencia);

                    if ($orgao_id != 0) {$query->where('ressarcimento_orgaos.id', $orgao_id);}
                })
                ->groupby('ressarcimento_cobrancas_dados.referencia')
                ->get();

            $val_tot = 0;
            if ($valores->count() > 0) {
                foreach ($valores as $valor) {
                    $val_tot += $valor['valor_pago'];
                }
            }
            $valores_pagos[] = number_format($val_tot, 2, '.', '');
        }

        $series[] = ['name' => 'Valor Devido', 'data' => $valores_devidos];
        $series[] = ['name' => 'Valor Pago', 'data' => $valores_pagos];

        $colors[] = "#556ee6";
        $colors[] = "#34c38f";

        $dados['series'] = $series;
        $dados['colors'] = $colors;
        $dados['xaxis_categories'] = $xaxis_categories;

        $dados['titulo1'] = 'Referências';
        $dados['titulo2'] = 'Valores';
        $dados['titulo3'] = 'Todos os Órgãos';

        if ($orgao_id != 0) {
            $orgao = RessarcimentoOrgao::where('id', $orgao_id)->get();
            $dados['titulo3'] = $orgao[0]['name'];
        }

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $dados), 200);
    }
}
