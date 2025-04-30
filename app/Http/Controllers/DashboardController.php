<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Models\Agrupamento;
use App\Models\Dashboard;
use App\Models\Esfera;
use App\Models\Grupo;
use App\Models\GrupoDashboard;
use App\Models\GrupoRelatorio;
use App\Models\Poder;
use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoOrgao;
use App\Models\RessarcimentoReferencia;
use App\Models\Transacao;
use App\Models\User;
use App\Models\UserDashboardViews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        //Retorno
        $content = array();

        //Agrupamentos do Usuário
        $content['agrupamentos'] = UserDashboardViews
            ::join('dashboards', 'dashboards.id', '=', 'users_dashboards_views.dashboard_id')
            ->join('grupos_dashboards', 'grupos_dashboards.dashboard_id', '=', 'dashboards.id')
            ->join('agrupamentos', 'agrupamentos.id', '=', 'dashboards.agrupamento_id')
            ->select('agrupamentos.*')
            ->distinct('agrupamentos.name')
            ->where('users_dashboards_views.user_id', Auth::user()->id)
            ->where('grupos_dashboards.grupo_id', Auth::user()->grupo_id)
            ->orderby('agrupamentos.ordem_visualizacao', 'ASC')
            ->get();

        //Retorno dashboards_modal_filtro_1
        $content['ressarcimento_referencias'] = RessarcimentoReferencia::select('referencia')->orderby('referencia', 'DESC')->get();
        $content['ressarcimento_orgaos'] = RessarcimentoOrgao::select('id', 'name')->orderby('name', 'ASC')->get();

        //Retorno dashboards_modal_filtro_2
        //WebService - DGF
        $parametros = array();
        $parametros['evento'] = 3;

        $registros = SuporteFacade::webserviceDgf($parametros);

        $content['subcontas'] = $registros['success'];

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function dashboard1()
    {
        //Array
        $dados = array();

        $dados['quantidade_grupos'] = Grupo::all()->count();
        $dados['quantidade_usuarios'] = User::all()->count();
        $dados['quantidade_transacoes'] = Transacao::all()->count();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboard2()
    {
        //Arrays de retorno
        $dados = array();
        $series_data = array();
        $xaxis_categories = array();

        $grupos = Grupo::all();

        foreach ($grupos as $grupo) {
            $usuariosQtd = User::where('grupo_id', $grupo['id'])->count();
            $series_data[] = $usuariosQtd;
            $xaxis_categories[] = $grupo['name'];
        }

        //Retorno
        $dados['quantidade_usuarios'] = User::all()->count();
        $dados['series_data'] = $series_data;
        $dados['xaxis_categories'] = $xaxis_categories;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboard3()
    {
        //Arrays de retorno
        $dados = array();
        $series_data = array();
        $xaxis_categories = array();

        $postos_graduacoes = User::select('militar_posto_graduacao', 'militar_posto_graduacao_ordem')->distinct('militar_posto_graduacao')->orderby('militar_posto_graduacao_ordem')->get();

        foreach ($postos_graduacoes as $posto_graduacao) {
            $usuariosQtd = User::where('militar_posto_graduacao', $posto_graduacao['militar_posto_graduacao'])->count();
            $series_data[] = $usuariosQtd;
            $xaxis_categories[] = $posto_graduacao['militar_posto_graduacao'];
        }

        //Retorno
        $dados['quantidade_usuarios'] = User::all()->count();
        $dados['series_data'] = $series_data;
        $dados['xaxis_categories'] = $xaxis_categories;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboard4()
    {
        //Arrays de retorno
        $dados = array();
        $series = array();
        $labels = array();

        $usuarios = User
            ::join('situacoes', 'situacoes.id', 'users.situacao_id')
            ->select('situacoes.name as situacao', DB::raw('count(*) as total'))
            ->groupby('situacao')
            ->get();
        foreach ($usuarios as $usuario) {
            $usuariosQtd = $usuario['total'];

            $series[] = $usuariosQtd;
            $labels[] = $usuario['situacao'];
        }

        //Retorno
        $dados['quantidade_usuarios'] = User::all()->count();
        $dados['series'] = $series;
        $dados['labels'] = $labels;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboard5()
    {
        //Arrays de retorno
        $dados = array();
        $series = array();
        $labels = array();

        $transacoes = Transacao
            ::join('operacoes', 'operacoes.id', 'transacoes.operacao_id')
            ->select('operacoes.name as operacao', DB::raw('count(*) as total'))
            ->groupby('operacao')
            ->get();
        foreach ($transacoes as $transacao) {
            $transacoesQtd = $transacao['total'];

            $series[] = $transacoesQtd;
            $labels[] = $name = $transacao['operacao'];
        }

        //Retorno
        $dados['quantidade_transacoes'] = Transacao::all()->count();
        $dados['series'] = $series;
        $dados['labels'] = $labels;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboard6($periodo1, $periodo2, $orgao_id)
    {
        //Arrays de retorno
        $dados = array();

        //Registros Órgãos
        $dados['quantidade_orgaos'] = RessarcimentoOrgao
            ::join('ressarcimento_militares', 'ressarcimento_militares.lotacao_id', 'ressarcimento_orgaos.lotacao_id')
            ->select('ressarcimento_orgaos.*')
            ->distinct('ressarcimento_orgaos.lotacao_id')
            ->where('ressarcimento_militares.referencia', '>=', $periodo1)
            ->where('ressarcimento_militares.referencia', '<=', $periodo2)
            ->count();

        //Registros Militares
        $dados['quantidade_militares'] = RessarcimentoMilitar
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

        $dados['valor_ressarcimento'] = $valor_ressarcimento;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboard7($periodo1, $periodo2, $orgao_id)
    {
        //Arrays de retorno
        $dados = array();

        //Registros Militares
        $dados['quantidade_militares'] = RessarcimentoMilitar
            ::where('referencia', '>=', $periodo1)
            ->where('referencia', '<=', $periodo2)
            ->count();

        //Registros Oficiais
        $dados['quantidade_oficiais'] = RessarcimentoMilitar
            ::where('referencia', '>=', $periodo1)
            ->where('referencia', '<=', $periodo2)
            ->where('oficial_praca', 1)
            ->count();

        //Registros Praças
        $dados['quantidade_pracas'] = RessarcimentoMilitar
            ::where('referencia', '>=', $periodo1)
            ->where('referencia', '<=', $periodo2)
            ->where('oficial_praca', 2)
            ->count();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboard8($periodo1, $periodo2, $orgao_id)
    {
        //Arrays de retorno
        $dados = array();
        $series_data = array();
        $xaxis_categories = array();

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
        }

        $series_data[] = $valores_devidos;
        $series_data[] = $valores_pagos;

        $xaxis_categories[] = 'Valor Devido';
        $xaxis_categories[] = 'Valor Pago';

        //Retorno
        $dados['series_data'] = $series_data;
        $dados['xaxis_categories'] = $xaxis_categories;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);

        //$series[] = ['name' => 'Valor Devido', 'data' => []];
        //$series[] = ['name' => 'Valor Pago', 'data' => []];
    }

    public function dashboard9($periodo1, $periodo2, $orgao_id)
    {
        //Arrays de retorno
        $dados = array();
        $series = array();
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
        }

        //Retorno
        $dados['quantidade_orgaos'] = RessarcimentoOrgao
            ::join('ressarcimento_militares', 'ressarcimento_militares.lotacao_id', 'ressarcimento_orgaos.lotacao_id')
            ->select('ressarcimento_orgaos.*')
            ->distinct('ressarcimento_orgaos.lotacao_id')
            ->where('ressarcimento_militares.referencia', '>=', $periodo1)
            ->where('ressarcimento_militares.referencia', '<=', $periodo2)
            ->count();
        $dados['series'] = $series;
        $dados['labels'] = $labels;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboard10($periodo1, $periodo2, $orgao_id)
    {
        //Arrays de retorno
        $dados = array();
        $series = array();
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
        }

        //Retorno
        $dados['quantidade_orgaos'] = RessarcimentoOrgao
            ::join('ressarcimento_militares', 'ressarcimento_militares.lotacao_id', 'ressarcimento_orgaos.lotacao_id')
            ->select('ressarcimento_orgaos.*')
            ->distinct('ressarcimento_orgaos.lotacao_id')
            ->where('ressarcimento_militares.referencia', '>=', $periodo1)
            ->where('ressarcimento_militares.referencia', '<=', $periodo2)
            ->count();
        $dados['series'] = $series;
        $dados['labels'] = $labels;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboard11($periodo1, $periodo2, $orgao_id)
    {
        //Arrays de retorno
        $dados = array();
        $series_data_valores_devidos = array();
        $series_data_valores_pagos = array();
        $xaxis_categories = array();
        $yaxis_min = 999999999999999;
        $yaxis_max = 0;

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
            $series_data_valores_devidos[] = $val_tot;

            //Verificando valor Mínimo e Máximo
            if ($val_tot < $yaxis_min) {$yaxis_min = $val_tot;}
            if ($val_tot > $yaxis_max) {$yaxis_max = $val_tot;}

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
            $series_data_valores_pagos[] = $val_tot;

            //Verificando valor Mínimo e Máximo
            if ($val_tot < $yaxis_min) {$yaxis_min = $val_tot;}
            if ($val_tot > $yaxis_max) {$yaxis_max = $val_tot;}
        }

        //Retorno
        $dados['series_data_valores_devidos'] = $series_data_valores_devidos;
        $dados['series_data_valores_pagos'] = $series_data_valores_pagos;
        $dados['xaxis_categories'] = $xaxis_categories;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboard12($data1, $data2, $subconta_id)
    {
        //Array
        $dados = array();

        //WebService - DGF
        $parametros = array();
        $parametros['evento'] = 4;
        $parametros['data1'] = $data1;
        $parametros['data2'] = $data2;
        $parametros['subconta_id'] = $subconta_id;

        $registros = SuporteFacade::webserviceDgf($parametros);
        $registros = $registros['success'];

        //Retorno
        $dados['total_repasses'] = $registros[0]['total_repasses'];
        $dados['total_despesas'] = $registros[0]['total_despesas'];

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboard13($data1, $data2, $subconta_id)
    {
        //WebService - DGF
        $parametros = array();
        $parametros['evento'] = 5;
        $parametros['data1'] = $data1;
        $parametros['data2'] = $data2;
        $parametros['subconta_id'] = $subconta_id;

        $registros = SuporteFacade::webserviceDgf($parametros);
        $registros = $registros['success'][0];

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function dashboard14($data1, $data2, $subconta_id)
    {
        //WebService - DGF
        $parametros = array();
        $parametros['evento'] = 5;
        $parametros['data1'] = $data1;
        $parametros['data2'] = $data2;
        $parametros['subconta_id'] = $subconta_id;

        $registros = SuporteFacade::webserviceDgf($parametros);
        $registros = $registros['success'][0];

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function dashboard15($data1, $data2, $subconta_id)
    {
        //WebService - DGF
        $parametros = array();
        $parametros['evento'] = 5;
        $parametros['data1'] = $data1;
        $parametros['data2'] = $data2;
        $parametros['subconta_id'] = $subconta_id;

        $registros = SuporteFacade::webserviceDgf($parametros);
        $registros = $registros['success'][0];

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function dashboard16($data1, $data2, $subconta_id)
    {
        //WebService - DGF
        $parametros = array();
        $parametros['evento'] = 5;
        $parametros['data1'] = $data1;
        $parametros['data2'] = $data2;
        $parametros['subconta_id'] = $subconta_id;

        $registros = SuporteFacade::webserviceDgf($parametros);
        $registros = $registros['success'][0];

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function dashboard17($data1, $data2, $subconta_id)
    {
        //WebService - DGF
        $parametros = array();
        $parametros['evento'] = 5;
        $parametros['data1'] = $data1;
        $parametros['data2'] = $data2;
        $parametros['subconta_id'] = $subconta_id;

        $registros = SuporteFacade::webserviceDgf($parametros);
        $registros = $registros['success'][0];

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function dashboards_ids($agrupamento_id)
    {
        //Array
        $dados = array();

        //Grupo Dashboards
        $dados['dashboards_ids'] = Dashboard
            ::join('users_dashboards_views', 'users_dashboards_views.dashboard_id', 'dashboards.id')
            ->where('agrupamento_id', $agrupamento_id)
            ->select('dashboards.id as id')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboards_views()
    {
        //Array
        $dados = array();

        //Agrupamentos do Usuário
        $dados['agrupamentos'] = UserDashboardViews
            ::join('dashboards', 'dashboards.id', '=', 'users_dashboards_views.dashboard_id')
            ->join('grupos_dashboards', 'grupos_dashboards.dashboard_id', '=', 'dashboards.id')
            ->join('agrupamentos', 'agrupamentos.id', '=', 'dashboards.agrupamento_id')
            ->select('agrupamentos.*')
            ->distinct('agrupamentos.name')
            ->where('users_dashboards_views.user_id', Auth::user()->id)
            ->where('grupos_dashboards.grupo_id', Auth::user()->grupo_id)
            ->orderby('agrupamentos.ordem_visualizacao', 'ASC')
            ->get();

        //Grupo Dashboards
        $dados['grupo_dashboards'] = GrupoDashboard
            ::join('grupos', 'grupos.id', '=', 'grupos_dashboards.grupo_id')
            ->join('dashboards', 'dashboards.id', '=', 'grupos_dashboards.dashboard_id')
            ->join('agrupamentos', 'agrupamentos.id', '=', 'dashboards.agrupamento_id')
            ->select('dashboards.id as dashboard_id', 'dashboards.name as dashboard_name', 'dashboards.descricao as dashboard_descricao', 'dashboards.principal_dashboard_id as dashboard_principal_dashboard_id', 'agrupamentos.id as dashboard_agrupamento_id', 'agrupamentos.name as dashboard_agrupamento')
            ->where('grupos_dashboards.grupo_id', Auth::user()->grupo_id)
            ->orderBy('dashboards.agrupamento_id')
            ->orderBy('dashboards.ordem_visualizacao')
            ->get();

        //Dashboards Views
        $dados['dashboards_views'] = UserDashboardViews
            ::join('dashboards', 'dashboards.id', '=', 'users_dashboards_views.dashboard_id')
            ->join('grupos_dashboards', 'grupos_dashboards.dashboard_id', '=', 'dashboards.id')
            ->select('users_dashboards_views.*')
            ->where('users_dashboards_views.user_id', Auth::user()->id)
            ->where('grupos_dashboards.grupo_id', Auth::user()->grupo_id)
            ->orderby('users_dashboards_views.ordem_visualizacao', 'ASC')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $dados);
    }

    public function dashboards_views_salvar(Request $request)
    {
        try {
            //Deletando registros na tabela users_dashboards_views
            UserDashboardViews::where('user_id', Auth::user()->id)->delete();

            //Incluindo registros na tabela users_dashboards_views
            $grupo_dashboards = GrupoDashboard::where('grupo_id', Auth::user()->grupo_id)->get();

            foreach ($grupo_dashboards as $grupo_dashboard) {
                if (isset($request['dashboard_id_'.$grupo_dashboard['dashboard_id']])) {
                    UserDashboardViews::create(['user_id' => Auth::user()->id, 'dashboard_id' => $request['dashboard_id_'.$grupo_dashboard['dashboard_id']], 'largura' => $request['largura_'.$grupo_dashboard['dashboard_id']], 'ordem_visualizacao' => $request['ordem_visualizacao_'.$grupo_dashboard['dashboard_id']]]);
                }
            }

            return $this->sendResponse('Registros atualizados com sucesso.', 2000, null, $request);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
}
