<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Models\Grupo;
use App\Models\GrupoDashboard;
use App\Models\Transacao;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $content = array();

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
            ->where('dashboards.modulo_id', 1)
            ->orderBy('dashboards.ordem_visualizacao')
            ->get();

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $acessos), 200);
    }

    public function dashboard1()
    {
        //Array
        $dados = array();

        $dados['gruposQtd'] = Grupo::all()->count();
        $dados['usuariosQtd'] = User::all()->count();
        $dados['transacoesQtd'] = Transacao::all()->count();

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $dados), 200);
    }

    public function dashboard2()
    {
        //Array de retorno
        $dados = array();

        //Series
        $series = array();

        $yaxis_max = 0;

        $grupos = Grupo::all();
        foreach ($grupos as $grupo) {
            $usuariosQtd = User::where('grupo_id', $grupo['id'])->count();
            $series[] = ['name' => $grupo['name'], 'data' => [$usuariosQtd]];

            if ($usuariosQtd > $yaxis_max) {$yaxis_max = $usuariosQtd;}
        }
        $dados['series'] = $series;

        //Usuários Qtd
        $dados['usuariosQtd'] = User::all()->count();

        //yaxis_max
        $dados['yaxis_max'] = $yaxis_max;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $dados), 200);
    }

    public function dashboard3()
    {
        //Array de retorno
        $dados = array();

        //Series
        $series = array();

        $yaxis_max = 0;

        $usuarios = User::select('militar_posto_graduacao_ordem', 'militar_posto_graduacao', DB::raw('count(*) as total'))->groupby('militar_posto_graduacao_ordem', 'militar_posto_graduacao')->orderby('militar_posto_graduacao_ordem', 'ASC')->get();
        foreach ($usuarios as $usuario) {
            $usuariosQtd = $usuario['total'];

            if ($usuario['militar_posto_graduacao'] == '') {$name = 'CIVIL';} else {$name = $usuario['militar_posto_graduacao'];}

            $series[] = ['name' => $name, 'data' => [$usuariosQtd]];

            if ($usuariosQtd > $yaxis_max) {$yaxis_max = $usuariosQtd;}
        }
        $dados['series'] = $series;

        //Usuários Qtd
        $dados['usuariosQtd'] = User::all()->count();

        //yaxis_max
        $dados['yaxis_max'] = $yaxis_max;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $dados), 200);
    }

    public function dashboard4()
    {
        //Array de retorno
        $dados = array();

        //Series
        $series = array();

        $yaxis_max = 0;

        $usuarios = User
            ::join('situacoes', 'situacoes.id', 'users.situacao_id')
            ->select('situacoes.name as situacao', DB::raw('count(*) as total'))
            ->groupby('situacao')
            ->get();
        foreach ($usuarios as $usuario) {
            $usuariosQtd = $usuario['total'];
            $name = $usuario['situacao'];

            $series[] = ['name' => $name, 'data' => [$usuariosQtd]];

            if ($usuariosQtd > $yaxis_max) {$yaxis_max = $usuariosQtd;}
        }
        $dados['series'] = $series;

        //Usuários Qtd
        $dados['usuariosQtd'] = User::all()->count();

        //yaxis_max
        $dados['yaxis_max'] = $yaxis_max;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $dados), 200);
    }

    public function dashboard5()
    {
        //Array de retorno
        $dados = array();

        //Series
        $series = array();

        $yaxis_max = 0;

        $transacoes = Transacao
            ::join('operacoes', 'operacoes.id', 'transacoes.operacao_id')
            ->select('operacoes.name as operacao', DB::raw('count(*) as total'))
            ->groupby('operacao')
            ->get();
        foreach ($transacoes as $transacao) {
            $transacoesQtd = $transacao['total'];
            $name = $transacao['operacao'];

            $series[] = ['name' => $name, 'data' => [$transacoesQtd]];

            if ($transacoesQtd > $yaxis_max) {$yaxis_max = $transacoesQtd;}
        }
        $dados['series'] = $series;

        //Transações Qtd
        $dados['transacoesQtd'] = Transacao::all()->count();

        //yaxis_max
        $dados['yaxis_max'] = $yaxis_max;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $dados), 200);
    }
}
