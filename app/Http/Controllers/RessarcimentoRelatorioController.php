<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Models\GrupoRelatorio;
use App\Models\Relatorio;
use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoOrgao;
use App\Models\RessarcimentoReferencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RessarcimentoRelatorioController extends Controller
{
    public function index()
    {
        //Variaveis
        $primeira_referencia = '';
        $ultima_referencia = '';

        //Referências
        $referencias = RessarcimentoReferencia::select('referencia')->orderby('referencia', 'DESC')->get();

        //Pegando primeira e ultima referencia
        $reg = 1;
        foreach ($referencias as $referencia) {
            //Pegando primeira referência
            $primeira_referencia = $referencia['referencia'];

            //Pegando Última referência
            if ($reg == 1) {$ultima_referencia = $referencia['referencia'];}

            $reg++;
        }

        //Retorno
        $content = array();
        $content['referencias'] = $referencias;
        $content['primeira_referencia'] = $primeira_referencia;
        $content['ultima_referencia'] = $ultima_referencia;
        $content['orgaos'] = RessarcimentoOrgao::select('id', 'name')->orderby('name', 'ASC')->get();

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
            ->where('relatorios.modulo_id', 3)
            ->orderBy('relatorios.ordem_visualizacao')
            ->get();

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $acessos), 200);
    }

    public function executar_relatorio_6($referencia, $orgao_id)
    {
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
        $registros = RessarcimentoCobrancaDado
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
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['registros'] = $registros;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $content), 200);
    }

    public function executar_relatorio_7($referencia, $orgao_id)
    {
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
        $registros = RessarcimentoCobrancaDado
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
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['registros'] = $registros;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $content), 200);
    }

    public function executar_relatorio_8($referencia, $orgao_id, $saldo)
    {
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
        $registros = RessarcimentoCobrancaDado
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
        foreach ($registros as $registro) {
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
        $registros = $dados;

        //Retorno
        $content = array();
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['registros'] = $registros;

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, '', $content), 200);
    }
}
