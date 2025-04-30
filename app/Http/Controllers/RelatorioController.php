<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Models\Ferramenta;
use App\Models\Notificacao;
use App\Models\Operacao;
use App\Models\Relatorio;
use App\Models\Situacao;
use App\Models\Submodulo;
use App\Models\Transacao;
use App\Models\User;
use App\Models\Agrupamento;
use App\Models\Esfera;
use App\Models\Grupo;
use App\Models\GrupoRelatorio;
use App\Models\Poder;
use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoOrgao;
use App\Models\RessarcimentoReferencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $content['referencias'] = RessarcimentoReferencia::select('referencia')->orderby('referencia', 'DESC')->get();
        $content['orgaos'] = RessarcimentoOrgao::select('id', 'name')->orderby('name', 'ASC')->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorios()
    {
        //Retorno
        $content = array();

        //Agrupamentos do Usuário
        $content['agrupamentos'] = Relatorio
            ::join('grupos_relatorios', 'grupos_relatorios.relatorio_id', '=', 'relatorios.id')
            ->join('agrupamentos', 'agrupamentos.id', '=', 'relatorios.agrupamento_id')
            ->select('agrupamentos.*')
            ->distinct('agrupamentos.name')
            ->where('grupos_relatorios.grupo_id', Auth::user()->grupo_id)
            ->orderby('agrupamentos.ordem_visualizacao', 'ASC')
            ->get();

        $content['grupo_relatorios'] = GrupoRelatorio
            ::join('relatorios', 'relatorios.id', 'grupos_relatorios.relatorio_id')
            ->select('relatorios.id as relatorio_id', 'relatorios.agrupamento_id', 'relatorios.name as relatorio_name', 'relatorios.descricao as relatorio_descricao', 'relatorios.ordem_visualizacao as relatorio_ordem_visualizacao')
            ->where('grupos_relatorios.grupo_id', Auth::user()->id)
            ->orderby('relatorios.agrupamento_id', 'ASC')
            ->orderby('relatorios.ordem_visualizacao', 'ASC')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio1($grupo_id)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

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
        $relatorio_registros = Grupo
            ::select('grupos.*')
            ->where(function($query) use($grupo_id) {
                if ($grupo_id != 0) {$query->where('grupos.id', $grupo_id);}
            })
            ->orderby('grupos.name')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio2($grupo_id, $situacao_id)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

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
        $relatorio_registros = User
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
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio3($data, $user_id, $submodulo_id, $operacao_id, $dado)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

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
        $relatorio_registros = Transacao
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
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio4($data, $title, $notificacao, $user_id)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

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
        $relatorio_registros = Notificacao
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
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio5($name, $descricao, $url, $user_id)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

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
        $relatorio_registros = Ferramenta
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
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio6($referencia, $orgao_id)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

        //Relatório Nome
        $relatorio = Relatorio::where('id', 6)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = SuporteFacade::getReferencia(1, $referencia);
        if ($orgao_id == 0) {
            $relatorio_parametros .= ' / '.'Todos os Órgãos';
        } else {
            $orgao = RessarcimentoOrgao::where('id', $orgao_id)->get();
            $relatorio_parametros .= ' / '.$orgao[0]['name'];
        }

        //Militares pela referencia e pelo(s) Órgão(s)
        $relatorio_registros = RessarcimentoCobrancaDado
            ::join('ressarcimento_militares', 'ressarcimento_militares.id', 'ressarcimento_cobrancas_dados.ressarcimento_militar_id')
            ->join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
            ->select(
                'ressarcimento_cobrancas_dados.referencia',
                'ressarcimento_orgaos.name as orgao_nome',
                'ressarcimento_militares.identidade_funcional as militar_identidade_funcional',
                'ressarcimento_militares.rg as militar_rg',
                'ressarcimento_militares.nome as militar_nome',
                'ressarcimento_militares.posto_graduacao as militar_posto_graduacao',
                'ressarcimento_militares.quadro_qbmp as militar_quadro')
            ->where(function($query) use($referencia, $orgao_id) {
                $query->where('ressarcimento_cobrancas_dados.referencia', $referencia);

                if ($orgao_id != 0) {$query->where('ressarcimento_orgaos.id', $orgao_id);}
            })
            ->orderby('ressarcimento_cobrancas_dados.referencia')
            ->orderby('ressarcimento_orgaos.name')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio7($referencia, $orgao_id)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

        //Relatório Nome
        $relatorio = Relatorio::where('id', 7)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = SuporteFacade::getReferencia(1, $referencia);
        if ($orgao_id == 0) {
            $relatorio_parametros .= ' / '.'Todos os Órgãos';
        } else {
            $orgao = RessarcimentoOrgao::where('id', $orgao_id)->get();
            $relatorio_parametros .= ' / '.$orgao[0]['name'];
        }

        //Registros
        $relatorio_registros = RessarcimentoCobrancaDado
            ::join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
            ->select(
                'ressarcimento_cobrancas_dados.referencia',
                'ressarcimento_cobrancas_dados.orgao_name',
                DB::raw('SUM(ressarcimento_cobrancas_dados.listagem_fonte10 + ressarcimento_cobrancas_dados.listagem_vencimento_bruto + ressarcimento_cobrancas_dados.listagem_folha_suplementar) as vencimentos_brutos'),
                DB::raw('SUM(ressarcimento_cobrancas_dados.listagem_rioprevidencia22 + ressarcimento_cobrancas_dados.listagem_fundo_saude_10) as encargos_sociais_e_patronais'),
                DB::raw('SUM(ressarcimento_cobrancas_dados.listagem_fonte10 + ressarcimento_cobrancas_dados.listagem_vencimento_bruto + ressarcimento_cobrancas_dados.listagem_folha_suplementar + ressarcimento_cobrancas_dados.listagem_rioprevidencia22 + ressarcimento_cobrancas_dados.listagem_fundo_saude_10) as ressarcimento'))
            ->where(function($query) use($referencia, $orgao_id) {
                $query->where('ressarcimento_cobrancas_dados.referencia', $referencia);

                if ($orgao_id != 0) {$query->where('ressarcimento_orgaos.id', $orgao_id);}
            })
            ->groupby('ressarcimento_cobrancas_dados.referencia')
            ->groupby('ressarcimento_cobrancas_dados.orgao_name')
            ->orderby('ressarcimento_cobrancas_dados.orgao_name')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function relatorio8($referencia, $orgao_id, $saldo)
    {
        //Relatório Data
        $relatorio_data = date('d/m/Y');

        //Relatório Hora
        $relatorio_hora = date('H:i:s');

        //Relatório Nome
        $relatorio = Relatorio::where('id', 8)->get();
        $relatorio_nome = $relatorio[0]['name'];

        //Parâmetros
        $relatorio_parametros = SuporteFacade::getReferencia(1, $referencia);
        if ($orgao_id == 0) {
            $relatorio_parametros .= ' / '.'Todos os Órgãos';
        } else {
            $orgao = RessarcimentoOrgao::where('id', $orgao_id)->get();
            $relatorio_parametros .= ' / '.$orgao[0]['name'];
        }
        if ($saldo == 0) {
            $relatorio_parametros .= ' / '.'Qualquer Saldo';
        } else if ($saldo == 1) {
            $relatorio_parametros .= ' / '.'Saldo igual a 0(zero)';
        } else if ($saldo == 2) {
            $relatorio_parametros .= ' / '.'Saldo menor que 0(zero)';
        } else if ($saldo == 3) {
            $relatorio_parametros .= ' / '.'Saldo maior que 0(zero)';
        }

        //Registros
        $relatorio_registros = RessarcimentoCobrancaDado
            ::join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
            ->join('ressarcimento_recebimentos', 'ressarcimento_recebimentos.ressarcimento_cobranca_dado_id', 'ressarcimento_cobrancas_dados.id')
            ->select(
                'ressarcimento_cobrancas_dados.referencia',
                'ressarcimento_cobrancas_dados.orgao_name',
                DB::raw('SUM(ressarcimento_cobrancas_dados.listagem_fonte10 + ressarcimento_cobrancas_dados.listagem_vencimento_bruto + ressarcimento_cobrancas_dados.listagem_folha_suplementar + ressarcimento_cobrancas_dados.listagem_rioprevidencia22 + ressarcimento_cobrancas_dados.listagem_fundo_saude_10) as ressarcimento'),
                DB::raw('SUM(ressarcimento_recebimentos.valor_recebido) as recebimento'),
                DB::raw('SUM((ressarcimento_cobrancas_dados.listagem_fonte10 + ressarcimento_cobrancas_dados.listagem_vencimento_bruto + ressarcimento_cobrancas_dados.listagem_folha_suplementar + ressarcimento_cobrancas_dados.listagem_rioprevidencia22 + ressarcimento_cobrancas_dados.listagem_fundo_saude_10) - (ressarcimento_recebimentos.valor_recebido)) as saldo')
            )->where(function($query) use($referencia, $orgao_id) {
                $query->where('ressarcimento_cobrancas_dados.referencia', $referencia);

                if ($orgao_id != 0) {$query->where('ressarcimento_orgaos.id', $orgao_id);}
            })
            ->groupby('ressarcimento_cobrancas_dados.referencia')
            ->groupby('ressarcimento_cobrancas_dados.orgao_name')
            ->orderby('ressarcimento_cobrancas_dados.orgao_name')
            ->get();

        //Verificar se é para filtrar os registros
        $dados = array();
        foreach ($relatorio_registros as $registro) {
            //Qualquer Saldo
            if ($saldo == 0) {
                $dados[] = $registro;
            }

            //Saldo igual a 0(zero)
            if ($saldo == 1) {
                if ($registro['saldo'] == 0) {
                    $dados[] = $registro;
                }
            }

            //Saldo menor que 0(zero)
            if ($saldo == 2) {
                if ($registro['saldo'] < 0) {
                    $dados[] = $registro;
                }
            }

            //Saldo maior que 0(zero)
            if ($saldo == 3) {
                if ($registro['saldo'] > 0) {
                    $dados[] = $registro;
                }
            }
        }
        $relatorio_registros = $dados;

        //Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }
}
