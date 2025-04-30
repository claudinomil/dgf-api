<?php

namespace App\Services;

use App\Models\Grupo;
use App\Models\Situacao;
use App\Models\Transacao;
use App\Models\User;
use App\Facades\SuporteFacade;
use App\Models\Esfera;
use App\Models\Funcao;
use App\Models\Poder;
use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoMilitar;
use App\Models\Tratamento;
use App\Models\Vocativo;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Transacoes
{
    public $abreSpan = "";
    public $fechaSpan = "";
    public $gravarAlteracao = false;

    public function retornaDado($op, $dadoAnterior, $dadoAtual, $etiqueta, $model, $modelCampoRetorno) {
        $retorno = '';

        if ($dadoAnterior != $dadoAtual) {
            $this->abreSpan = "<font class='text-danger'>";
            $this->fechaSpan = "</font>";

            $this->gravarAlteracao = true;
        } else {
            $this->abreSpan = "";
            $this->fechaSpan = "";
        }

        //Opção para campos sem id's simples, com apenas um retorno
        if ($op == 1) {
            //Verificar se é uma data e converter para d/m/Y
            if (strlen($dadoAtual) == 10 and substr($dadoAtual, 4, 1) == '-' and substr($dadoAtual, 7, 1) == '-') {
                $dadoAtual = Carbon::createFromFormat('Y-m-d', $dadoAtual)->format('d/m/Y');
            }

            //Return
            $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $dadoAtual . "<br>";
        }

        //Opção para campos id's simples, com apenas um retorno
        if ($op == 2) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $search = $model::where('id', $dadoAtual)->get([$modelCampoRetorno]);
                $retorno = $this->abreSpan . ':: ' . $etiqueta . ": " . $this->fechaSpan . $search[0][$modelCampoRetorno] . "<br>";
            }
        }

        //Opção para o campo ressarcimento_cobranca_dado_id
        if ($op == 3) {
            if (($dadoAtual != "") and ($dadoAtual != 0)) {
                $cobranca_dado = RessarcimentoCobrancaDado::where('id', $dadoAtual)->get(['referencia', 'orgao_name', 'militar_nome', 'militar_posto_graduacao']);

                $dados = $this->abreSpan . ':: ' . "Referência:" . ": " . $this->fechaSpan.SuporteFacade::getReferencia(1, $cobranca_dado[0]['referencia'])."<br>";
                $dados .= $this->abreSpan . ':: ' . "Órgão: " . ": " . $this->fechaSpan.$cobranca_dado[0]['orgao_name']."<br>";
                $dados .= $this->abreSpan . ':: ' . "Militar: " . ": " . $this->fechaSpan.$cobranca_dado[0]['militar_posto_graduacao'].' '.$cobranca_dado[0]['militar_nome']."<br>";

                $retorno = $dados . "<br>";
            }
        }

        return $retorno;
    }

    /*
     * Função para Gravar Transação
     *
     * @PARAM op=1 : Transação na tabela principal do Submódulo
     * @PARAM op=? : Transação em tabelas pivot ou outras tabelas referentes ao Submódulo
     */
    public function transacaoRecord($op=1, $operacao, $submodulo, $dadosAnterior, $dadosAtual, $userLoggedId='') {
        //Verificação do Usuário Logado
        $userVerificado = true;

        if ($userLoggedId == '') {
            if (Auth::check()) {
                $userLoggedId = Auth::user()->id;
            } else {
                $userVerificado = false;
            }
        }

        //Gravar transação
        if ($userVerificado) {
            //submodulo_id'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $data = DB::table('submodulos')->select(['id'])->where('prefix_route', $submodulo)->get()->toArray();

            $submodulo_id = $data[0]->id;
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //montar campo dados'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $dados = '';

            //users
            if ($submodulo_id == 1) {
                if ($op == 1) {
                    $dados .= '<b>:: Usuários</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['email'], $dadosAtual['email'], 'E-mail', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['avatar'], $dadosAtual['avatar'], 'Avatar', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['grupo_id'], $dadosAtual['grupo_id'], 'Grupo', Grupo::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['situacao_id'], $dadosAtual['situacao_id'], 'Situação', Situacao::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['layout_mode'], $dadosAtual['layout_mode'], 'Layout Mode', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['layout_style'], $dadosAtual['layout_style'], 'Layout Style', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['militar_rg'], $dadosAtual['militar_rg'], 'Militar RG', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['militar_nome'], $dadosAtual['militar_nome'], 'Militar Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['militar_posto_graduacao'], $dadosAtual['militar_posto_graduacao'], 'Militar Posto/Graduação', '', '');
                }
            }

            //grupos
            if ($submodulo_id == 2) {
                if ($op == 1) {
                    $dados .= '<b>:: Grupos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['controle_transacao'], $dadosAtual['controle_transacao'], 'Controle Transação', '', '');
                }
            }

            //notificacoes
            if ($submodulo_id == 3) {
                if ($op == 1) {
                    $dados .= '<b>:: Notificações</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['date'], $dadosAtual['date'], 'Data', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['time'], $dadosAtual['time'], 'Hora', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['title'], $dadosAtual['title'], 'Título', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['notificacao'], $dadosAtual['notificacao'], 'Notificação', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['user_id'], $dadosAtual['user_id'], 'Usuário', User::class, 'name');
                }
            }

            //ferramentas
            if ($submodulo_id == 5) {
                if ($op == 1) {
                    $dados .= '<b>:: Ferramentas</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['descricao'], $dadosAtual['descricao'], 'Descrição', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['url'], $dadosAtual['url'], 'URL', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['icon'], $dadosAtual['icon'], 'Ícone', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['user_id'], $dadosAtual['user_id'], 'Usuário', User::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ordem_visualizacao'], $dadosAtual['ordem_visualizacao'], 'Ordem Visualização', '', '');
                }
            }

            //Ressarcimento Configuracoes
            if ($submodulo_id == 6) {
                if ($op == 1) {
                    $dados .= '<b>:: Ressarcimento Configurações</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, SuporteFacade::getReferencia(1, $dadosAnterior['referencia']), SuporteFacade::getReferencia(1, $dadosAtual['referencia']), 'Referência', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['data_vencimento'], $dadosAtual['data_vencimento'], 'Data Vencimento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['diretor_identidade_funcional'], $dadosAtual['diretor_identidade_funcional'], 'Diretor Identidade Funcional', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['diretor_rg'], $dadosAtual['diretor_rg'], 'Diretor RG', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['diretor_nome'], $dadosAtual['diretor_nome'], 'Diretor Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['diretor_posto'], $dadosAtual['diretor_posto'], 'Diretor Posto', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['diretor_quadro'], $dadosAtual['diretor_quadro'], 'Diretor Quadro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['diretor_cargo'], $dadosAtual['diretor_cargo'], 'Diretor Cargo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['dgf2_identidade_funcional'], $dadosAtual['dgf2_identidade_funcional'], 'DGF/2 Identidade Funcional', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['dgf2_rg'], $dadosAtual['dgf2_rg'], 'DGF/2 RG', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['dgf2_nome'], $dadosAtual['dgf2_nome'], 'DGF/2 Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['dgf2_posto'], $dadosAtual['dgf2_posto'], 'DGF/2 Posto', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['dgf2_quadro'], $dadosAtual['dgf2_quadro'], 'DGF/2 Quadro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['dgf2_cargo'], $dadosAtual['dgf2_cargo'], 'DGF/2 Cargo', '', '');
                }
            }

            //Ressarcimento Referências
            if ($submodulo_id == 7) {
                if ($op == 1) {
                    $dados .= '<b>:: Ressarcimento Referências</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, SuporteFacade::getReferencia(1, $dadosAnterior['referencia']), SuporteFacade::getReferencia(1, $dadosAtual['referencia']), 'Referência', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ano'], $dadosAtual['ano'], 'Ano', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['mes'], $dadosAtual['mes'], 'Mês', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['parte'], $dadosAtual['parte'], 'Parte', '', '');
                }
            }

            //Ressarcimento Orgaos
            if ($submodulo_id == 10) {
                if ($op == 1) {
                    $dados .= '<b>:: Ressarcimento Órgãos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cnpj'], $dadosAtual['cnpj'], 'CNPJ', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ug'], $dadosAtual['ug'], 'UG', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['responsavel'], $dadosAtual['responsavel'], 'Responsável', '', '');
                    $dados .= $this->retornaDado(2, $dadosAnterior['esfera_id'], $dadosAtual['esfera_id'], 'Esfera', Esfera::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['poder_id'], $dadosAtual['poder_id'], 'Poder', Poder::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['tratamento_id'], $dadosAtual['tratamento_id'], 'Tratamento', Tratamento::class, 'completo');
                    $dados .= $this->retornaDado(2, $dadosAnterior['vocativo_id'], $dadosAtual['vocativo_id'], 'Vocativo', Vocativo::class, 'name');
                    $dados .= $this->retornaDado(2, $dadosAnterior['funcao_id'], $dadosAtual['funcao_id'], 'Função', Funcao::class, 'name');
                    $dados .= $this->retornaDado(1, $dadosAnterior['telefone_1'], $dadosAtual['telefone_1'], 'Telefone 1', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['telefone_2'], $dadosAtual['telefone_2'], 'Telefone 2', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cep'], $dadosAtual['cep'], 'CEP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero'], $dadosAtual['numero'], 'Número', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['complemento'], $dadosAtual['complemento'], 'Complemento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['logradouro'], $dadosAtual['logradouro'], 'Logradouro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['bairro'], $dadosAtual['bairro'], 'Bairro', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['localidade'], $dadosAtual['localidade'], 'Localidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['uf'], $dadosAtual['uf'], 'UF', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['contato_nome'], $dadosAtual['contato_nome'], 'Contato Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['contato_telefone'], $dadosAtual['contato_telefone'], 'Contato Telefone', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['contato_celular'], $dadosAtual['contato_celular'], 'Contato Celular', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['contato_email'], $dadosAtual['contato_email'], 'Contato E-mail', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['lotacao_id'], $dadosAtual['lotacao_id'], 'Lotação ID', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['lotacao'], $dadosAtual['lotacao'], 'Lotação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['realizar_cobranca'], $dadosAtual['realizar_cobranca'], 'Realizar Cobrança', '', '');
                }
            }

            //Ressarcimento Pagamentos
            if ($submodulo_id == 11) {
                if ($op == 1) {
                    $dados .= '<b>:: Ressarcimento Pagamentos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(2, $dadosAnterior['ressarcimento_militar_id'], $dadosAtual['ressarcimento_militar_id'], 'Militar', RessarcimentoMilitar::class, 'nome');
                    $dados .= $this->retornaDado(1, SuporteFacade::getReferencia(1, $dadosAnterior['referencia']), SuporteFacade::getReferencia(1, $dadosAtual['referencia']), 'Referência', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['identidade_funcional'], $dadosAtual['identidade_funcional'], 'Identidade Funcional', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['vinculo'], $dadosAtual['vinculo'], 'Vínculo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['rg'], $dadosAtual['rg'], 'RG', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['codigo_cargo'], $dadosAtual['codigo_cargo'], 'Código Cargo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['nome_cargo'], $dadosAtual['nome_cargo'], 'Nome Cargo', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['posto_graduacao'], $dadosAtual['posto_graduacao'], 'Posto Graduação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['nivel'], $dadosAtual['nivel'], 'Nível', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['nome'], $dadosAtual['nome'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['situacao_pagamento'], $dadosAtual['situacao_pagamento'], 'Situação Pagamento', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getDataFormatada(1, $dadosAnterior['data_ingresso']), SuporteFacade::getDataFormatada(1, $dadosAtual['data_ingresso']), 'Data Ingresso', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getDataFormatada(1, $dadosAnterior['data_nascimento']), SuporteFacade::getDataFormatada(1, $dadosAtual['data_nascimento']), 'Data Nascimento', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getDataFormatada(1, $dadosAnterior['data_aposentadoria']), SuporteFacade::getDataFormatada(1, $dadosAtual['data_aposentadoria']), 'Data Aposentadoria', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['genero'], $dadosAtual['genero'], 'Gênero', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['codigo_ua'], $dadosAtual['codigo_ua'], 'Código UA', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ua'], $dadosAtual['ua'], 'UA', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cpf'], $dadosAtual['cpf'], 'CPF', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['pasep'], $dadosAtual['pasep'], 'PASEP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['banco'], $dadosAtual['banco'], 'Banco', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['agencia'], $dadosAtual['agencia'], 'Agência', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['conta_corrente'], $dadosAtual['conta_corrente'], 'Conta Corrente', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['numero_dependentes'], $dadosAtual['numero_dependentes'], 'Número Dependentes', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['ir_dependente'], $dadosAtual['ir_dependente'], 'IR Dependente', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cotista'], $dadosAtual['cotista'], 'Cotista', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['bruto']), SuporteFacade::getValorFormatado(2, $dadosAtual['bruto']), 'Bruto', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['desconto']), SuporteFacade::getValorFormatado(2, $dadosAtual['desconto']), 'Desconto', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['liquido']), SuporteFacade::getValorFormatado(2, $dadosAtual['liquido']), 'Líquido', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['soldo']), SuporteFacade::getValorFormatado(2, $dadosAtual['soldo']), 'Soldo', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['hospital10']), SuporteFacade::getValorFormatado(2, $dadosAtual['hospital10']), 'Hospital 10', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['rioprevidencia22']), SuporteFacade::getValorFormatado(2, $dadosAtual['rioprevidencia22']), 'Rioprevidência 22', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['etapa_ferias']), SuporteFacade::getValorFormatado(2, $dadosAtual['etapa_ferias']), 'Etapa Férias', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['etapa_destacado']), SuporteFacade::getValorFormatado(2, $dadosAtual['etapa_destacado']), 'Etapa Destacado', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['ajuda_fardamento']), SuporteFacade::getValorFormatado(2, $dadosAtual['ajuda_fardamento']), 'Ajuda Fardamento', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['habilitacao_profissional']), SuporteFacade::getValorFormatado(2, $dadosAtual['habilitacao_profissional']), 'Habilitação Profissional', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['gret']), SuporteFacade::getValorFormatado(2, $dadosAtual['gret']), 'GRET', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['auxilio_moradia']), SuporteFacade::getValorFormatado(2, $dadosAtual['auxilio_moradia']), 'Auxílio Moradia', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['gpe']), SuporteFacade::getValorFormatado(2, $dadosAtual['gpe']), 'GPE', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['gee_capacitacao']), SuporteFacade::getValorFormatado(2, $dadosAtual['gee_capacitacao']), 'GEE Capacitação', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['decreto14407']), SuporteFacade::getValorFormatado(2, $dadosAtual['decreto14407']), 'Decreto 14407', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['ferias']), SuporteFacade::getValorFormatado(2, $dadosAtual['ferias']), 'Férias', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['raio_x']), SuporteFacade::getValorFormatado(2, $dadosAtual['raio_x']), 'Raio X', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['trienio']), SuporteFacade::getValorFormatado(2, $dadosAtual['trienio']), 'Triênio', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['auxilio_invalidez']), SuporteFacade::getValorFormatado(2, $dadosAtual['auxilio_invalidez']), 'Auxílio Invalidez', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['tempo_certo']), SuporteFacade::getValorFormatado(2, $dadosAtual['tempo_certo']), 'Tempo Certo', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['fundo_saude']), SuporteFacade::getValorFormatado(2, $dadosAtual['fundo_saude']), 'Fundo Saúde', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['abono_permanencia']), SuporteFacade::getValorFormatado(2, $dadosAtual['abono_permanencia']), 'Abono Permanência', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['deducao_ir']), SuporteFacade::getValorFormatado(2, $dadosAtual['deducao_ir']), 'Dedução IR', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['ir_valor']), SuporteFacade::getValorFormatado(2, $dadosAtual['ir_valor']), 'IR Valor', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['auxilio_transporte']), SuporteFacade::getValorFormatado(2, $dadosAtual['auxilio_transporte']), 'Auxílio Transporte', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['gram']), SuporteFacade::getValorFormatado(2, $dadosAtual['gram']), 'GRAM', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['auxilio_fardamento']), SuporteFacade::getValorFormatado(2, $dadosAtual['auxilio_fardamento']), 'Auxílio Fardamento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['cidade'], $dadosAtual['cidade'], 'Cidade', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['observacao'], $dadosAtual['observacao'], 'Observação', '', '');
                }
            }

            //Ressarcimento Militares
            if ($submodulo_id == 12) {
                if ($op == 1) {
                    $dados .= '<b>:: Ressarcimento Militares</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, SuporteFacade::getReferencia(1, $dadosAnterior['referencia']), SuporteFacade::getReferencia(1, $dadosAtual['referencia']), 'Referência', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['identidade_funcional'], $dadosAtual['identidade_funcional'], 'Identidade Funcional', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['rg'], $dadosAtual['rg'], 'RG', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['nome'], $dadosAtual['nome'], 'Nome', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['posto_graduacao'], $dadosAtual['posto_graduacao'], 'Posto Graduação', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['quadro_qbmp'], $dadosAtual['quadro_qbmp'], 'Quadro QBMP', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['boletim'], $dadosAtual['boletim'], 'Boletim', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['lotacao_id'], $dadosAtual['lotacao_id'], 'Lotação ID', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['lotacao'], $dadosAtual['lotacao'], 'Lotação', '', '');
                }
            }

            //Ressarcimento Recebimentos
            if ($submodulo_id == 14) {
                if ($op == 1) {
                    $dados .= '<b>:: Ressarcimento Recebimentos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(3, $dadosAnterior['ressarcimento_cobranca_dado_id'], $dadosAtual['ressarcimento_cobranca_dado_id'], '', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getDataFormatada(1, $dadosAnterior['data_recebimento']), SuporteFacade::getDataFormatada(1, $dadosAtual['data_recebimento']), 'Data Recebimento', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['valor_recebido']), SuporteFacade::getValorFormatado(2, $dadosAtual['valor_recebido']), 'Valor Recebido', '', '');
                    $dados .= $this->retornaDado(1, SuporteFacade::getValorFormatado(2, $dadosAnterior['saldo_restante']), SuporteFacade::getValorFormatado(2, $dadosAtual['saldo_restante']), 'Saldo Restante', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['guia_recolhimento'], $dadosAtual['guia_recolhimento'], 'Guia Recolhimento', '', '');
                    $dados .= $this->retornaDado(1, $dadosAnterior['documento'], $dadosAtual['documento'], 'Documento', '', '');
                }
            }

            //Alimentação Tipos
            if ($submodulo_id == 19) {
                if ($op == 1) {
                    $dados .= '<b>:: Alimentação Tipos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //Alimentação Planos
            if ($submodulo_id == 20) {
                if ($op == 1) {
                    $dados .= '<b>:: Alimentação Planos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //Alimentação Unidades
            if ($submodulo_id == 21) {
                if ($op == 1) {
                    $dados .= '<b>:: Alimentação Unidades</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //Alimentação Remanejamentos
            if ($submodulo_id == 22) {
                if ($op == 1) {
                    $dados .= '<b>:: Alimentação Remanejamentos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }

            //Alimentação Quantitativos
            if ($submodulo_id == 23) {
                if ($op == 1) {
                    $dados .= '<b>:: Alimentação Quantitativos</b>'.'<br><br>';
                    $dados .= $this->retornaDado(1, $dadosAnterior['name'], $dadosAtual['name'], 'Nome', '', '');
                }
            }
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificando se é uma alteração e pode gravar (caso nenhum campo tenha sido alterado não deixar gravar)''''
            if ($operacao == 2 and $this->gravarAlteracao === false) {
                $dados = '';
            } else {
                $this->gravarAlteracao = false;
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //gravar transacao''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if ($dados != '') {
                $trasaction = Array();

                $trasaction['date'] = date('Y-m-d');
                $trasaction['time'] = date('H:i:s');
                $trasaction['user_id'] = $userLoggedId;
                $trasaction['operacao_id'] = $operacao;
                $trasaction['submodulo_id'] = $submodulo_id;
                $trasaction['dados'] = $dados;

                Transacao::create($trasaction);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        }

        return true;
    }
}
