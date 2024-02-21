<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Models\Ferramenta;
use App\Models\Grupo;
use App\Models\GrupoRelatorio;
use App\Models\Notificacao;
use App\Models\Operacao;
use App\Models\Relatorio;
use App\Models\Situacao;
use App\Models\Submodulo;
use App\Models\Transacao;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RelatorioController extends Controller
{
    public function index()
    {
        //Retorno
        $content = array();
        $content['grupos'] = Grupo::orderby('name')->get();
        $content['situacoes'] = Situacao::orderby('name')->get();
        $content['users'] = User::orderby('name')->get();
        $content['submodulos'] = Submodulo::orderby('name')->get();
        $content['operacoes'] = Operacao::orderby('name')->get();

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $content), 200);
    }

    public function acessos()
    {
        $acessos = GrupoRelatorio
            ::join('grupos', 'grupos_relatorios.grupo_id', '=', 'grupos.id')
            ->join('relatorios', 'grupos_relatorios.relatorio_id', '=', 'relatorios.id')
            ->join('modulos', 'modulos.id', '=', 'relatorios.modulo_id')
            ->select('relatorios.id as relatorio_id', 'relatorios.name as relatorio_name', 'relatorios.descricao as relatorio_descricao', 'modulos.name as relatorio_modulo', 'modulos.menu_text as relatorio_modulo', 'modulos.menu_icon as relatorio_icone')
            ->where('grupos_relatorios.grupo_id', Auth::user()->grupo_id)
            ->where('relatorios.modulo_id', 1)
            ->orderBy('relatorios.ordem_visualizacao')
            ->get();

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $acessos), 200);
    }

    public function executar_relatorio_1($grupo_id)
    {
        //Relatório Nome
        $relatorio = Relatorio::where('id', 1)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = '';
        if ($grupo_id == 0) {
            $relatorio_parametros .= 'Todos os Grupos';
        } else {
            $grupo = Grupo::where('id', $grupo_id)->get();
            $relatorio_parametros .= $grupo[0]['name'];
        }

        //Registros
        $registros = Grupo
            ::select('grupos.*')
            ->where(function($query) use($grupo_id) {
                if ($grupo_id != 0) {$query->where('grupos.id', $grupo_id);}
            })
            ->orderby('grupos.name')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['registros'] = $registros;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $content), 200);
    }

    public function executar_relatorio_2($grupo_id, $situacao_id)
    {
        //Relatório Nome
        $relatorio = Relatorio::where('id', 2)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = '';
        if ($grupo_id == 0) {
            $relatorio_parametros .= 'Todos os Grupos';
        } else {
            $grupo = Grupo::where('id', $grupo_id)->get();
            $relatorio_parametros .= $grupo[0]['name'];
        }
        if ($situacao_id == 0) {
            $relatorio_parametros .= ' / '.'Todos as Situações';
        } else {
            $situacao = Situacao::where('id', $situacao_id)->get();
            $relatorio_parametros .= ' / '.$situacao[0]['name'];
        }

        //Registros
        $registros = User
            ::join('grupos', 'grupos.id', 'users.grupo_id')
            ->join('situacoes', 'situacoes.id', 'users.situacao_id')
            ->select('users.*', 'grupos.name as grupo', 'situacoes.name as situacao')
            ->where(function($query) use($grupo_id, $situacao_id) {
                if ($grupo_id != 0) {$query->where('grupos.id', $grupo_id);}
                if ($situacao_id != 0) {$query->where('situacoes.id', $situacao_id);}
            })
            ->orderby('users.militar_posto_graduacao_ordem')
            ->orderby('users.militar_rg')
            ->orderby('users.name')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['registros'] = $registros;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $content), 200);
    }

    public function executar_relatorio_3($data, $user_id, $submodulo_id, $operacao_id, $dado)
    {
        //Relatório Nome
        $relatorio = Relatorio::where('id', 3)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = '';
        if ($data != 'xxxyyyzzz') {
            $relatorio_parametros .= SuporteFacade::getDataFormatada(1, $data);
        }
        if ($user_id == 0) {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= 'Todos os Usuários';
        } else {
            $user = User::where('id', $user_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $user[0]['name'];
        }
        if ($submodulo_id == 0) {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= 'Todos os Submódulos';
        } else {
            $submodulo = Submodulo::where('id', $submodulo_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $submodulo[0]['name'];
        }
        if ($operacao_id == 0) {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= 'Todas as Operações';
        } else {
            $operacao = Operacao::where('id', $operacao_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $operacao[0]['name'];
        }
        if ($dado != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $dado;
        }

        //Registros
        $registros = Transacao
            ::join('users', 'users.id', 'transacoes.user_id')
            ->join('submodulos', 'submodulos.id', 'transacoes.submodulo_id')
            ->join('operacoes', 'operacoes.id', 'transacoes.operacao_id')
            ->select('transacoes.*', 'users.name as user', 'submodulos.name as submodulo', 'operacoes.name as operacao')
            ->where(function($query) use($data, $user_id, $submodulo_id, $operacao_id, $dado) {
                if ($data != 'xxxyyyzzz') {$query->where('transacoes.date', $data);}
                if ($user_id != 0) {$query->where('transacoes.user_id', $user_id);}
                if ($submodulo_id != 0) {$query->where('transacoes.submodulo_id', $submodulo_id);}
                if ($operacao_id != 0) {$query->where('transacoes.operacao_id', $operacao_id);}
                if ($dado != 'xxxyyyzzz') {$query->where('transacoes.dados', 'LIKE', '%'.$dado.'%');}
            })
            ->orderby('transacoes.date')
            ->orderby('submodulos.name')
            ->orderby('users.name')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['registros'] = $registros;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $content), 200);
    }

    public function executar_relatorio_4($data, $title, $notificacao, $user_id)
    {
        //Relatório Nome
        $relatorio = Relatorio::where('id', 4)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = '';

        if ($data != 'xxxyyyzzz') {
            $relatorio_parametros .= SuporteFacade::getDataFormatada(1, $data);
        }
        if ($title != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $title;
        }
        if ($notificacao != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $notificacao;
        }
        if ($user_id == 0) {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= 'Todos os Usuários';
        } else {
            $user = User::where('id', $user_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $user[0]['name'];
        }

        //Registros
        $registros = Notificacao
            ::join('users', 'users.id', 'notificacoes.user_id')
            ->select('notificacoes.*', 'users.name as user')
            ->where(function($query) use($data, $title, $notificacao, $user_id) {
                if ($data != 'xxxyyyzzz') {$query->where('notificacoes.date', $data);}
                if ($title != 'xxxyyyzzz') {$query->where('notificacoes.title', 'LIKE', '%'.$title.'%');}
                if ($notificacao != 'xxxyyyzzz') {$query->where('notificacoes.notificacao', 'LIKE', '%'.$notificacao.'%');}
                if ($user_id != 0) {$query->where('notificacoes.user_id', $user_id);}
            })
            ->orderby('notificacoes.date')
            ->orderby('notificacoes.time')
            ->orderby('notificacoes.user_id')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['registros'] = $registros;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $content), 200);
    }

    public function executar_relatorio_5($name, $descricao, $url, $user_id)
    {
        //Relatório Nome
        $relatorio = Relatorio::where('id', 5)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = '';

        if ($name != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $name;
        }
        if ($descricao != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $descricao;
        }
        if ($url != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $url;
        }
        if ($user_id == 0) {
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= 'Todos os Usuários';
        } else {
            $user = User::where('id', $user_id)->get();
            if ($relatorio_parametros != '') {$relatorio_parametros .= ' / ';}
            $relatorio_parametros .= $user[0]['name'];
        }

        //Registros
        $registros = Ferramenta
            ::join('users', 'users.id', 'ferramentas.user_id')
            ->select('ferramentas.*', 'users.name as user')
            ->where(function($query) use($name, $descricao, $url, $user_id) {
                if ($name != 'xxxyyyzzz') {$query->where('ferramentas.name', 'LIKE', '%'.$name.'%');}
                if ($descricao != 'xxxyyyzzz') {$query->where('ferramentas.descricao', 'LIKE', '%'.$descricao.'%');}
                if ($url != 'xxxyyyzzz') {$query->where('ferramentas.url', 'LIKE', '%'.$url.'%');}
                if ($user_id != 0) {$query->where('ferramentas.user_id', $user_id);}
            })
            ->orderby('ferramentas.name')
            ->orderby('ferramentas.url')
            ->orderby('ferramentas.user_id')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['registros'] = $registros;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $content), 200);
    }
}
