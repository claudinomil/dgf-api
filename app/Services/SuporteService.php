<?php

namespace App\Services;

use App\Models\GrupoDashboard;
use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\RessarcimentoCobranca;
use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoCobrancaPdfListagem;
use App\Models\RessarcimentoCobrancaPdfListagemDado;
use App\Models\RessarcimentoCobrancaPdfNota;
use App\Models\RessarcimentoCobrancaPdfOficio;
use App\Models\RessarcimentoRecebimento;
use App\Models\Transacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SuporteService
{
    /*
     * Retornar referencia
     * @PARAM op=1 : recebe 20230902 e retorna setembro de 2023 parte 02
     * @PARAM op=2 : recebe 202309 e retorna setembro de 2023
     * @PARAM op=3 : recebe setembro de 2023 parte 02 e retorna 20230902
     * @PARAM op=4 : recebe setembro de 2023 e retorna 202309
     */
    public function getReferencia($op, $referencia)
    {
        if ($op == 1) {
            $ano = substr($referencia, 0, 4);
            $mes = substr($referencia, 4, 2);
            $parte = substr($referencia, 6, 2);
            $mes_extenso = $this->getMes(1, $mes);

            return $mes_extenso. ' de '.$ano.' parte '.$parte;
        }

        if ($op == 2) {
            $ano = substr($referencia, 0, 4);
            $mes = substr($referencia, 4);
            $mes_extenso = $this->getMes(1, $mes);

            return $mes_extenso. ' de '.$ano;
        }

        if ($op == 3) {
            $explode = explode('', $referencia);

            $parte = $explode[4];
            $ano = $explode[2];
            $mes_extenso = $explode[0];
            $mes = $this->getMes(2, $mes_extenso);

            return $ano.$mes.$parte;
        }

        if ($op == 4) {
            $explode = explode('', $referencia);

            $ano = $explode[2];
            $mes_extenso = $explode[0];
            $mes = $this->getMes(2, $mes_extenso);

            return $ano.$mes;
        }

        return false;
    }

    /*
     * Retornar Mês e Mês por Extenso
     * @PARAM op=1 = retorna Mês por Extenso
     * @PARAM op=2 = retorna Mês Numeral
     * @PARAM op=3 = retorna Mês por Extenso (com três letras)
     * @PARAM op=4 = retorna Mês Numeral (recebe $mes com três letras)
     */
    public function getMes($op, $mes)
    {
        if ($op == 1) {
            if (strlen($mes) == 1) {$mes = '0'.$mes;}

            if ($mes == '01') {return 'janeiro';}
            if ($mes == '02') {return 'fevereiro';}
            if ($mes == '03') {return 'março';}
            if ($mes == '04') {return 'abril';}
            if ($mes == '05') {return 'maio';}
            if ($mes == '06') {return 'junho';}
            if ($mes == '07') {return 'julho';}
            if ($mes == '08') {return 'agosto';}
            if ($mes == '09') {return 'setembro';}
            if ($mes == '10') {return 'outubro';}
            if ($mes == '11') {return 'novembro';}
            if ($mes == '12') {return 'dezembro';}
        }

        if ($op == 2) {
            if ($mes == 'janeiro') {return '01';}
            if ($mes == 'fevereiro') {return '02';}
            if ($mes == 'março') {return '03';}
            if ($mes == 'abril') {return '04';}
            if ($mes == 'maio') {return '05';}
            if ($mes == 'junho') {return '06';}
            if ($mes == 'julho') {return '07';}
            if ($mes == 'agosto') {return '08';}
            if ($mes == 'setembro') {return '09';}
            if ($mes == 'outubro') {return '10';}
            if ($mes == 'novembro') {return '11';}
            if ($mes == 'dezembro') {return '12';}
        }

        if ($op == 3) {
            if (strlen($mes) == 1) {$mes = '0'.$mes;}

            if ($mes == '01') {return 'jan';}
            if ($mes == '02') {return 'fev';}
            if ($mes == '03') {return 'mar';}
            if ($mes == '04') {return 'abr';}
            if ($mes == '05') {return 'mai';}
            if ($mes == '06') {return 'jun';}
            if ($mes == '07') {return 'jul';}
            if ($mes == '08') {return 'ago';}
            if ($mes == '09') {return 'set';}
            if ($mes == '10') {return 'out';}
            if ($mes == '11') {return 'nov';}
            if ($mes == '12') {return 'dez';}
        }

        if ($op == 3) {
            if ($mes == 'jan') {return '01';}
            if ($mes == 'fev') {return '02';}
            if ($mes == 'mar') {return '03';}
            if ($mes == 'abr') {return '04';}
            if ($mes == 'mai') {return '05';}
            if ($mes == 'jun') {return '06';}
            if ($mes == 'jul') {return '07';}
            if ($mes == 'ago') {return '08';}
            if ($mes == 'set') {return '09';}
            if ($mes == 'out') {return '10';}
            if ($mes == 'nov') {return '11';}
            if ($mes == 'dez') {return '12';}
        }

        return false;
    }

    /*
     * Retornar proximo ano e numero de uma Nota para gravar na tabela ressarcimento_cobrancas_pdfs_listagens
     */
    public function getAnoNumeroNota()
    {
        //Ano/Número inicial
        $anoNumeroNota = date('Y').'1';

        //Ultimo registro gerado
        $ultimoRegistro = RessarcimentoCobrancaPdfListagem::orderby('nota_ano', 'DESC')->orderby('nota_numero', 'DESC')->first();

        if ($ultimoRegistro) {
            $ano = $ultimoRegistro['nota_ano'];
            $numero = $ultimoRegistro['nota_numero'];

            if ($ano == date('Y')) {
                $numero = intval($numero);
                $numero = $numero + 1;

                $anoNumeroNota = $ano.$numero;
            }
        }

        return $anoNumeroNota;
    }

    /*
     * Retornar proximo ano e numero de um Ofício para gravar na tabela ressarcimento_cobrancas_pdfs_oficios
     */
    public function getAnoNumeroOficio()
    {
        //Ano/Número inicial
        $anoNumeroOficio = date('Y').'1';

        //Ultimo registro gerado
        $ultimoRegistro = RessarcimentoCobrancaPdfOficio::orderby('oficio_ano', 'DESC')->orderby('oficio_numero', 'DESC')->first();

        if ($ultimoRegistro) {
            $ano = $ultimoRegistro['oficio_ano'];
            $numero = $ultimoRegistro['oficio_numero'];

            if ($ano == date('Y')) {
                $numero = intval($numero);
                $numero = $numero + 1;

                $anoNumeroOficio = $ano.$numero;
            }
        }

        return $anoNumeroOficio;
    }

    /*
     * Deletar Cobrança de uma determinada Referência
     * Deletará registros de cobrança nas seguintes tabelas:
     * :: ressarcimento_cobrancas
     * :: ressarcimento_cobrancas_dados
     * :: ressarcimento_recebimentos
     * :: ressarcimento_cobrancas_pdfs_listagens
     * :: ressarcimento_cobrancas_pdfs_listagens_dados
     * :: ressarcimento_cobrancas_pdfs_notas
     * :: ressarcimento_cobrancas_pdfs_oficios
     */
    public function delCobranca($referencia)
    {
        //Apagando registros tabela ressarcimento_cobrancas
        RessarcimentoCobranca::where('referencia', $referencia)->delete();

        //Apagando registros tabela ressarcimento_cobrancas_dados
        $registros = RessarcimentoCobrancaDado::where('referencia', $referencia)->get();

        foreach ($registros as $registro) {
            $id_excluir = $registro['id'];

            RessarcimentoRecebimento::where('ressarcimento_cobranca_dado_id', $id_excluir)->delete();
            RessarcimentoCobrancaDado::where('id', $id_excluir)->delete();
        }

        //Apagando registros tabela ressarcimento_cobrancas_pdfs_listagens
        $registros = RessarcimentoCobrancaPdfListagem::where('referencia', $referencia)->get();

        foreach ($registros as $registro) {
            $id_excluir = $registro['id'];

            RessarcimentoCobrancaPdfListagemDado::where('ressarcimento_cobranca_pdf_listagem_id', $id_excluir)->delete();
            RessarcimentoCobrancaPdfListagem::where('id', $id_excluir)->delete();
        }

        //Apagando registros tabela ressarcimento_cobrancas_pdfs_notas
        RessarcimentoCobrancaPdfNota::where('referencia', $referencia)->delete();

        //Apagando registros tabela ressarcimento_cobrancas_pdfs_oficios
        RessarcimentoCobrancaPdfOficio::where('referencia', $referencia)->delete();

        return true;
    }

    public function gerarCorAleatoria() {
        $cor = '#'.dechex(rand(0x000000, 0xFFFFFF));
        return $cor;
    }

    /*
     * Retornar data formatada
     * A) Recebe formatos de datas: 99/99/9999 ou 99-99-9999 ou 9999/99/99 ou 9999-99-99
     * B) Depois retorna essa data no formato pedido pelo usuário
     * @PARAM op=1 = recebe qualquer data e retorna 99/99/9999
     * @PARAM op=2 = recebe qualquer data e retorna 99-99-9999
     * @PARAM op=3 = recebe qualquer data e retorna 9999/99/99
     * @PARAM op=4 = recebe qualquer data e retorna 9999-99-99
     */
    public function getDataFormatada($op, $data)
    {
        //Variáveis para formatar o retorno
        $dia = '';
        $mes = '';
        $ano = '';

        //Verificando recebimento da data
        if ($data == '') {
            $data = null;
        } else {
            //Retirando espaços
            $data = trim($data);
            $data = str_replace(" ", "", $data);

            //Formato: 9999-99-99
            if (is_numeric(substr($data, 0, 4)) and substr($data, 4, 1) == '-' and is_numeric(substr($data, 5, 2)) and substr($data, 7, 1) == '-' and is_numeric(substr($data, 8, 2))) {
                $dia = substr($data, 8, 2);
                $mes = substr($data, 5, 2);
                $ano = substr($data, 0, 4);
            }

            //Formato: 9999/99/99
            if (is_numeric(substr($data, 0, 4)) and substr($data, 4, 1) == '/' and is_numeric(substr($data, 5, 2)) and substr($data, 7, 1) == '/' and is_numeric(substr($data, 8, 2))) {
                $dia = substr($data, 8, 2);
                $mes = substr($data, 5, 2);
                $ano = substr($data, 0, 4);
            }

            //Formato: 99-99-9999
            if (is_numeric(substr($data, 0, 2)) and substr($data, 2, 1) == '-' and is_numeric(substr($data, 3, 2)) and substr($data, 5, 1) == '-' and is_numeric(substr($data, 6, 4))) {
                $dia = substr($data, 0, 2);
                $mes = substr($data, 3, 2);
                $ano = substr($data, 6, 4);
            }

            //Formato: 99/99/9999
            if (is_numeric(substr($data, 0, 2)) and substr($data, 2, 1) == '/' and is_numeric(substr($data, 3, 2)) and substr($data, 5, 1) == '/' and is_numeric(substr($data, 6, 4))) {
                $dia = substr($data, 0, 2);
                $mes = substr($data, 3, 2);
                $ano = substr($data, 6, 4);
            }
        }

        //Retorno
        if ($dia == '' or $mes == '' or $ano == '' or $dia == '00' or $mes == '00' or $ano == '0000') {
            $data = null;
        } else {
            //Retorna no formato (99/99/9999)
            if ($op == 1) {$data = $dia.'/'.$mes.'/'.$ano;}

            //Retorna no formato (99-99-9999)
            if ($op == 2) {$data = $dia.'-'.$mes.'-'.$ano;}

            //Retorna no formato (9999/99/99)
            if ($op == 3) {$data = $ano.'/'.$mes.'/'.$dia;}

            //Retorna no formato (9999-99-99)
            if ($op == 4) {$data = $ano.'-'.$mes.'-'.$dia;}
        }

        return $data;
    }

    /*
     * Retornar valor formatado
     * A) Recebe qualquer número e transforma ele para o formato 123456.78
     * B) Depois retorna esse número no formato pedido pelo usuário
     * @PARAM op=1 = recebe qualquer número e retorna 123456.78
     * @PARAM op=2 = recebe qualquer número e retorna 123.456,78
     * @PARAM op=3 = recebe qualquer número e retorna 123,456.78
     * @PARAM op=4 = recebe qualquer número e retorna 123456,78
     */
    public function getValorFormatado($op, $valor)
    {
        if ($valor == '') {
            $valor = 0;
        }

        //Retirando espaços
        $valor = trim($valor);
        $valor = str_replace(" ", "", $valor);

        //Montando um array com cada digito
        $dados = str_split($valor);

        //Guardar ultima posição de um ponto/virgula
        $ponto_virgula = 0;

        //Posição da casa decimal
        $posicao_casa_decimal = 0;

        //posição
        $posicao = 0;
        foreach ($dados as $dado) {
            //Verificando e guardando caso o dígito seja um ponto
            if ($dado == '.') {
                $ponto_virgula = 1;
                $posicao_casa_decimal = $posicao;
            }

            //Verificando e guardando caso o dígito seja uma vírgula
            if ($dado == ',') {
                $ponto_virgula = 2;
                $posicao_casa_decimal = $posicao;
            }

            $posicao++;
        }

        //Refazer valor retirando pontos/vírgulas nas separações de milhares
        $valor = '';

        //posição
        $posicao = 0;
        foreach ($dados as $dado) {
            //Se dígito for um ponto/vírgula
            if ($dado == '.' or $dado == ',') {
                //Se for o ponto/vírgula da casa decimal (concatenar ao valor)
                if ($posicao_casa_decimal == $posicao) {$valor .= $dado;}
            } else {
                //concatenar ao valor
                $valor .= $dado;
            }

            $posicao++;
        }

        //Se valor tem vírgula trocar por ponto
        if ($ponto_virgula == 2) {
            $valor = str_replace(',', '.', $valor);
        }

        //Retorna no formato (123456.78)
        if ($op == 1) {
            $valor = number_format($valor, '2', '.', '');
        }

        //Retorna no formato (123.456,78)
        if ($op == 2) {
            $valor = number_format($valor, '2', ',', '.');
        }

        //Retorna no formato (123,456.78)
        if ($op == 3) {
            $valor = number_format($valor, '2', '.', ',');
        }

        //Retorna no formato (123456,78)
        if ($op == 4) {
            $valor = number_format($valor, '2', ',', '');
        }

        return $valor;
    }

    /*
     * WebService - DGF
     */
    public function webserviceDgf($parametros) {
        //Parâmetros
        if (isset($parametros['evento'])) {$evento = $parametros['evento'];} else {$evento = 0;}
        if (isset($parametros['field'])) {$field = $parametros['field'];} else {$field = '';}
        if (isset($parametros['value'])) {$value = $parametros['value'];} else {$value = '';}
        if (isset($parametros['limit'])) {$limit = $parametros['limit'];} else {$limit = 500;}
        if (isset($parametros['selectWhere'])) {$selectWhere = $parametros['selectWhere'];} else {$selectWhere = '';}
        if (isset($parametros['data1'])) {$data1 = $parametros['data1'];} else {$data1 = '';}
        if (isset($parametros['data2'])) {$data2 = $parametros['data2'];} else {$data2 = '';}
        if (isset($parametros['subconta_id'])) {$subconta_id = $parametros['subconta_id'];} else {$subconta_id = 0;}

        //Response
        $response = Http::get("http://dgf.rj.gov.br/sites/sistema/service_sistema_dgf.php", [
            'token' => 'hg4t@hb%gfdRRR$$$hk999R@@@hvfCLAU',
            'evento' => $evento,
            'field' => $field,
            'value' => $value,
            'limit' => $limit,
            'selectWhere' => $selectWhere,
            'data1' => $data1,
            'data2' => $data2,
            'subconta_id' => $subconta_id
        ]);
        return $response;
    }

    /*
     * Formatar RG
     * @PARAM op=0 : limpar RG (retira barra, ponto e zeros a esquerda)
     * @PARAM op=1 : recebe 00/0027.335 e retorna 27335
     * @PARAM op=2 : recebe 27335 e retorna 00/0027.335
     * @PARAM op=3 : recebe 27.335 e retorna 27335
     * @PARAM op=4 : recebe 27335 e retorna 27.335
     */
    public function getRG($op, $rg) {
        if ($op == 0) {
            $rg = str_replace('/', '', $rg);
            $rg = str_replace('.', '', $rg);
            $rg = str_replace(' ', '', $rg);
            $rg = trim($rg);
            $rg = intval($rg);
        }

        if ($op == 1) {
            $rg = str_replace('/', '', $rg);
            $rg = str_replace('.', '', $rg);

            for($i=0; $i<7; $i++) {
                if (substr($rg, 0, 1) == '0') {
                    $rg = substr($rg, 1);
                } else {
                    exit;
                }
            }
        }

        if ($op == 2) {
            if (strlen($rg) == 7) {$rg = '00/'.substr($rg, 0, 4) . '.' . substr($rg, 4, 3);}
            if (strlen($rg) == 6) {$rg = '00/'.'0' . substr($rg, 0, 3) . '.' . substr($rg, 3, 3);}
            if (strlen($rg) == 5) {$rg = '00/'.'00' . substr($rg, 0, 2) . '.' . substr($rg, 2, 3);}
            if (strlen($rg) == 4) {$rg = '00/'.'000' . substr($rg, 0, 1) . '.' . substr($rg, 1, 3);}
            if (strlen($rg) == 3) {$rg = '00/'.'0000.' . $rg;}
            if (strlen($rg) == 2) {$rg = '00/'.'0000.0' . $rg;}
            if (strlen($rg) == 1) {$rg = '00/'.'0000.00' . $rg;}
        }

        if ($op == 3) {
            $rg = str_replace('.', '', $rg);
        }

        if ($op == 4) {
            if (strlen($rg) == 7) {$rg = substr($rg, 0, 4) . '.' . substr($rg, 4, 3);}
            if (strlen($rg) == 6) {$rg = substr($rg, 0, 3) . '.' . substr($rg, 3, 3);}
            if (strlen($rg) == 5) {$rg = substr($rg, 0, 2) . '.' . substr($rg, 2, 3);}
            if (strlen($rg) == 4) {$rg = substr($rg, 0, 1) . '.' . substr($rg, 1, 3);}
            if (strlen($rg) == 3) {$rg = $rg;}
            if (strlen($rg) == 2) {$rg = $rg;}
            if (strlen($rg) == 1) {$rg = $rg;}
        }

        return $rg;
    }

    /*
     * Verificar relacionamento em tabela
     * Retornar quantidade de registros
     */
    public function verificarRelacionamento($table, $field, $value)
    {
        $qtd = DB::table($table)->where($field, $value)->count();

        return $qtd;
    }

    //Alterando Transações: colocando abaixo as Permissões, Dashboards e Relatórios'''''''''''''''''''''''''''''
    //Pegando informação do campo "dados" da transação gravada
    public function gravarTransacaoGrupo($grupo_id, $controle_transacao) {
        $transacao = Transacao::select('dados')->where('dados', 'like', '%'.$controle_transacao.'%')->get()[0];

        $dados = $transacao['dados'];

        //Permissões
        $dados .= '<br>'.'<b>:: Permissões</b>'.'<br><br>';

        $permissoes = GrupoPermissao
            ::join('permissoes', 'permissoes.id', 'grupos_permissoes.permissao_id')
            ->select('description')
            ->where('grupos_permissoes.grupo_id', $grupo_id)
            ->get();

        foreach ($permissoes as $permissao) {
            $dados .= ':: ' . $permissao['description'] . "<br>";
        }

        //Dashboards
        $dados .= '<br>'.'<b>:: Dashboards</b>'.'<br><br>';

        $dashboards = GrupoDashboard
            ::join('dashboards', 'dashboards.id', 'grupos_dashboards.dashboard_id')
            ->select('dashboards.name')
            ->where('grupos_dashboards.grupo_id', $grupo_id)
            ->get();

        foreach ($dashboards as $dashboard) {
            $dados .= ':: ' . $dashboard['name'] . "<br>";
        }

        //Relatorios
        $dados .= '<br>'.'<b>:: Relatórios</b>'.'<br><br>';

        $relatorios = GrupoRelatorio
            ::join('relatorios', 'relatorios.id', 'grupos_relatorios.relatorio_id')
            ->select('relatorios.name')
            ->where('grupos_relatorios.grupo_id', $grupo_id)
            ->get();

        foreach ($relatorios as $relatorio) {
            $dados .= ':: ' . $relatorio['name'] . "<br>";
        }

        //Transação editando
        Transacao::where('dados', 'like', '%'.$controle_transacao.'%')->update(['dados' => $dados]);
    }
}
