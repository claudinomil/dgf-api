<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Models\Modulo;
use App\Models\RessarcimentoCobranca;
use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoCobrancaPdfListagem;
use App\Models\RessarcimentoCobrancaPdfListagemDado;
use App\Models\RessarcimentoCobrancaPdfNota;
use App\Models\RessarcimentoCobrancaPdfOficio;
use App\Models\RessarcimentoConfiguracao;
use App\Models\RessarcimentoPagamento;
use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoOrgao;
use App\Models\RessarcimentoRecebimento;
use App\Models\RessarcimentoReferencia;

class RessarcimentoCobrancaController extends Controller
{
    /*
     * Retornar dados do Ressarcimento para configuração da view
     */
    public function index($prefix_permissao)
    {
        $content = array();

        //Ícone do Módulo
        $icone = Modulo::join('submodulos', 'submodulos.modulo_id', 'modulos.id')->where('submodulos.prefix_permissao', $prefix_permissao)->get('modulos.menu_icon');
        $content['icone'] = $icone[0]['menu_icon'];

        //Referências com Militares já importados
        $referencias = RessarcimentoMilitar::select('referencia')->distinct()->orderby('referencia', 'DESC')->get();
        $content['referencias'] = $referencias;

        return $this->sendResponse('Dados enviados com sucesso.', 2000, null, $content);
    }

    /*
     * Retornar dados do Ressarcimento por referência
     */
    public function dados_ressarcimento($referencia)
    {
        //Array de retorno
        $content = array();

        //Registros Órgãos
        $orgaos = RessarcimentoOrgao
            ::join('ressarcimento_militares', 'ressarcimento_militares.lotacao_id', 'ressarcimento_orgaos.lotacao_id')
            ->select('ressarcimento_orgaos.*')
            ->distinct('ressarcimento_orgaos.lotacao_id')
            ->where('ressarcimento_militares.referencia', $referencia)
            ->get();

        //Registros Militares
        $militares = RessarcimentoMilitar::where('referencia', $referencia)->get();

        //Registros Pagamentos
        $pagamentos = RessarcimentoPagamento::where('referencia', $referencia)->get();

        //Registros Configurações
        $configuracoes = RessarcimentoConfiguracao::where('referencia', $referencia)->get();

        //Registros Cobrancas
        $cobrancas_dados = RessarcimentoCobrancaDado::where('referencia', $referencia)->get();

        //Registros Cobrancas PDFs Listagens
        $cobrancas_pdfs_listagens = RessarcimentoCobrancaPdfListagem::where('referencia', $referencia)->get();

        //Registros Cobrancas PDFs Notas
        $cobrancas_pdfs_notas = RessarcimentoCobrancaPdfNota::where('referencia', $referencia)->get();

        //Registros Cobrancas PDFs Ofícios
        $cobrancas_pdfs_oficios = RessarcimentoCobrancaPdfOficio::where('referencia', $referencia)->get();

        //Grade de Status dos Dados - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Grade de Status dos Dados - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Array para guardar dados da grade de Status dos Dados
        $registros_grade_status_dados = array(); //colunas: Status / Detalhes

        //Variáveis de Controle''''''''
        $re_status_dados = 1;
        $re_status_dados_texto = 'Dados Ok.';
        //'''''''''''''''''''''''''''''

        //Verificar Órgãos : se existe para todos os Militares''''''''''''''''''
        //Colunas
        if ($orgaos->count() > 0) {
            $status_cor = 'success';
            $status = 'Quantidade de Órgãos Ok';
        } else {
            //Variáveis de Controle''''''''
            $re_status_dados = 0;
            $re_status_dados_texto = 'Dados Falhou.';
            //'''''''''''''''''''''''''''''

            $status_cor = 'danger';
            $status = 'Não existem registros de Órgãos';
        }

        $detalhes = '';

        //Varrer militares
        foreach ($militares as $militar) {
            $lotacao_id = $militar['lotacao_id'];
            $lotacao = $militar['lotacao'];
            $militar_nome = $militar['nome'];
            $lotacao_encontrada = false;

            foreach ($orgaos as $orgao) {
                if ($orgao['lotacao_id'] == $lotacao_id) {
                    $lotacao_encontrada = true;
                    break;
                }
            }

            if ($lotacao_encontrada === false) {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                //Colunas
                $status_cor = 'danger';
                $status = 'Existem Militares sem registro de Órgãos';
                $detalhes .= $militar_nome.'<br>';
            }
        }

        $registros_grade_status_dados[] = [
            'status_cor' => $status_cor,
            'status' => $status,
            'detalhes' => $detalhes
        ];
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Verificar Órgãos : se existem dados incompletos'''''''''''''''''''''''
        //Colunas
        if ($orgaos->count() > 0) {
            $status_cor = 'success';
            $status = 'Dados de Órgãos completos';
        } else {
            //Variáveis de Controle''''''''
            $re_status_dados = 0;
            $re_status_dados_texto = 'Dados Falhou.';
            //'''''''''''''''''''''''''''''

            $status_cor = 'danger';
            $status = 'Não existem registros de Órgãos';
        }

        $detalhes = '';

        //Varrer militares
        foreach ($orgaos as $orgao) {
            $orgao_nome = $orgao['name'];

            if ($orgao['name'] == '' or $orgao['name'] === null
                //or $orgao['cnpj'] == '' or $orgao['cnpj'] === null
                //or $orgao['ug'] == '' or $orgao['ug'] === null
                //or $orgao['responsavel'] == '' or $orgao['responsavel'] === null
                or $orgao['esfera_id'] == '' or $orgao['esfera_id'] === null
                or $orgao['poder_id'] == '' or $orgao['poder_id'] === null
                or $orgao['tratamento_id'] == '' or $orgao['tratamento_id'] === null
                or $orgao['vocativo_id'] == '' or $orgao['vocativo_id'] === null
                or $orgao['funcao_id'] == '' or $orgao['funcao_id'] === null
                //or $orgao['telefone_1'] == '' or $orgao['telefone_1'] === null
                //or $orgao['telefone_2'] == '' or $orgao['telefone_2'] === null
                or $orgao['cep'] == '' or $orgao['cep'] === null
                or $orgao['numero'] == '' or $orgao['numero'] === null
                //or $orgao['complemento'] == '' or $orgao['complemento'] === null
                //or $orgao['logradouro'] == '' or $orgao['logradouro'] === null
                //or $orgao['bairro'] == '' or $orgao['bairro'] === null
                //or $orgao['localidade'] == '' or $orgao['localidade'] === null
                //or $orgao['uf'] == '' or $orgao['uf'] === null
                //or $orgao['contato_nome'] == '' or $orgao['contato_nome'] === null
                //or $orgao['contato_telefone'] == '' or $orgao['contato_telefone'] === null
                //or $orgao['contato_celular'] == '' or $orgao['contato_celular'] === null
                //or $orgao['contato_email'] == '' or $orgao['contato_email'] === null
                //or $orgao['lotacao_id'] == '' or $orgao['lotacao_id'] === null
                //or $orgao['lotacao'] == '' or $orgao['lotacao'] === null
                //or $orgao['realizar_cobranca'] == '' or $orgao['realizar_cobranca'] === null
                ) {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                //Colunas
                $status_cor = 'danger';
                $status = 'Existem registros de Órgãos incompletos';
                $detalhes .= $orgao_nome.'<br>';
            }
        }

        $registros_grade_status_dados[] = [
            'status_cor' => $status_cor,
            'status' => $status,
            'detalhes' => $detalhes
        ];
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Verificar Militares : se existem dados incompletos''''''''''''''''''''
        //Colunas
        $status_cor = 'success';
        $status = 'Dados de Militares completos';
        $detalhes = '';

        //Varrer militares
        foreach ($militares as $militar) {
            $militar_nome = $militar['nome'];

            if ($militar['identidade_funcional'] == '' or $militar['identidade_funcional'] === null
                or $militar['rg'] == '' or $militar['rg'] === null
                or $militar['nome'] == '' or $militar['nome'] === null
                or $militar['posto_graduacao'] == '' or $militar['posto_graduacao'] === null
                or $militar['quadro_qbmp'] == '' or $militar['quadro_qbmp'] === null
                or $militar['boletim'] == '' or $militar['boletim'] === null
                or $militar['lotacao_id'] == '' or $militar['lotacao_id'] === null
                or $militar['lotacao'] == '' or $militar['lotacao'] === null) {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                //Colunas
                $status_cor = 'danger';
                $status = 'Existem registros de Militares incompletos';
                $detalhes .= $militar_nome.'<br>';
            }
        }

        $registros_grade_status_dados[] = [
            'status_cor' => $status_cor,
            'status' => $status,
            'detalhes' => $detalhes
        ];
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Verificar Pagamentos : se existe para todos os Militares'''''''''''
        //Colunas
        if ($pagamentos->count() > 0) {
            $status_cor = 'success';
            $status = 'Quantidade de Pagamentos Ok';
        } else {
            //Variáveis de Controle''''''''
            $re_status_dados = 0;
            $re_status_dados_texto = 'Dados Falhou.';
            //'''''''''''''''''''''''''''''

            $status_cor = 'danger';
            $status = 'Não existem registros de Pagamentos';
        }

        $detalhes = '';

        //Varrer militares
        foreach ($militares as $militar) {
            $militar_nome = $militar['nome'];
            $identidade_funcional = $militar['identidade_funcional'];
            $identidade_funcional_encontrada = false;

            foreach ($pagamentos as $pagamento) {
                if ($pagamento['identidade_funcional'] == $identidade_funcional) {
                    $identidade_funcional_encontrada = true;
                    break;
                }
            }

            if ($identidade_funcional_encontrada === false) {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                //Colunas
                $status_cor = 'danger';
                $status = 'Existem Militares sem registro de Pagamentos';
                $detalhes .= $militar_nome.'<br>';
            }
        }

        $registros_grade_status_dados[] = [
            'status_cor' => $status_cor,
            'status' => $status,
            'detalhes' => $detalhes
        ];
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Verificar Pagamentos : se existem dados incompletos''''''''''''''''
        //Colunas
        if ($pagamentos->count() > 0) {
            $status_cor = 'success';
            $status = 'Dados de Pagamentos completos';
        } else {
            //Variáveis de Controle''''''''
            $re_status_dados = 0;
            $re_status_dados_texto = 'Dados Falhou.';
            //'''''''''''''''''''''''''''''

            $status_cor = 'danger';
            $status = 'Não existem registros de Pagamentos';
        }

        $detalhes = '';

        //Varrer Pagamentos
        foreach ($pagamentos as $pagamento) {
            $pagamento_nome = $pagamento['nome'];

            if ($pagamento['identidade_funcional'] == '' or $pagamento['identidade_funcional'] === null
                or $pagamento['vinculo'] == '' or $pagamento['vinculo'] === null
                or $pagamento['rg'] == '' or $pagamento['rg'] === null
                or $pagamento['codigo_cargo'] == '' or $pagamento['codigo_cargo'] === null
                or $pagamento['nome_cargo'] == '' or $pagamento['nome_cargo'] === null
                or $pagamento['posto_graduacao'] == '' or $pagamento['posto_graduacao'] === null
//                or $pagamento['nivel'] == '' or $pagamento['nivel'] === null
                or $pagamento['nome'] == '' or $pagamento['nome'] === null
                or $pagamento['situacao_pagamento'] == '' or $pagamento['situacao_pagamento'] === null
                or $pagamento['data_ingresso'] == '' or $pagamento['data_ingresso'] === null
                or $pagamento['data_nascimento'] == '' or $pagamento['data_nascimento'] === null
                or $pagamento['genero'] == '' or $pagamento['genero'] === null
                or $pagamento['codigo_ua'] == '' or $pagamento['codigo_ua'] === null
                or $pagamento['ua'] == '' or $pagamento['ua'] === null
                or $pagamento['cpf'] == '' or $pagamento['cpf'] === null
                or $pagamento['pasep'] == '' or $pagamento['pasep'] === null
                or $pagamento['banco'] == '' or $pagamento['banco'] === null
                or $pagamento['agencia'] == '' or $pagamento['agencia'] === null
                or $pagamento['conta_corrente'] == '' or $pagamento['conta_corrente'] === null
                or $pagamento['numero_dependentes'] == '' or $pagamento['numero_dependentes'] === null
                or $pagamento['ir_dependente'] == '' or $pagamento['ir_dependente'] === null
                or $pagamento['cotista'] == '' or $pagamento['cotista'] === null
                or $pagamento['bruto'] == '' or $pagamento['bruto'] === null
                or $pagamento['desconto'] == '' or $pagamento['desconto'] === null
                or $pagamento['liquido'] == '' or $pagamento['liquido'] === null
                or $pagamento['soldo'] == '' or $pagamento['soldo'] === null
                or $pagamento['hospital10'] == '' or $pagamento['hospital10'] === null
                or $pagamento['rioprevidencia22'] == '' or $pagamento['rioprevidencia22'] === null
                or $pagamento['etapa_ferias'] == '' or $pagamento['etapa_ferias'] === null
                or $pagamento['etapa_destacado'] == '' or $pagamento['etapa_destacado'] === null
                or $pagamento['ajuda_fardamento'] == '' or $pagamento['ajuda_fardamento'] === null
                or $pagamento['habilitacao_profissional'] == '' or $pagamento['habilitacao_profissional'] === null
                or $pagamento['gret'] == '' or $pagamento['gret'] === null
                or $pagamento['auxilio_moradia'] == '' or $pagamento['auxilio_moradia'] === null
                or $pagamento['gpe'] == '' or $pagamento['gpe'] === null
                or $pagamento['gee_capacitacao'] == '' or $pagamento['gee_capacitacao'] === null
                or $pagamento['decreto14407'] == '' or $pagamento['decreto14407'] === null
                or $pagamento['ferias'] == '' or $pagamento['ferias'] === null
                or $pagamento['raio_x'] == '' or $pagamento['raio_x'] === null
                or $pagamento['trienio'] == '' or $pagamento['trienio'] === null
                or $pagamento['auxilio_invalidez'] == '' or $pagamento['auxilio_invalidez'] === null
                or $pagamento['tempo_certo'] == '' or $pagamento['tempo_certo'] === null
                or $pagamento['fundo_saude'] == '' or $pagamento['fundo_saude'] === null
                or $pagamento['abono_permanencia'] == '' or $pagamento['abono_permanencia'] === null
                or $pagamento['deducao_ir'] == '' or $pagamento['deducao_ir'] === null
                or $pagamento['ir_valor'] == '' or $pagamento['ir_valor'] === null
                or $pagamento['auxilio_transporte'] == '' or $pagamento['auxilio_transporte'] === null
                or $pagamento['gram'] == '' or $pagamento['gram'] === null
                or $pagamento['auxilio_fardamento'] == '' or $pagamento['auxilio_fardamento'] === null
                or $pagamento['cidade'] == '' or $pagamento['cidade'] === null) {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                //Colunas
                $status_cor = 'danger';
                $status = 'Existem registros de Pagamentos incompletos';
                $detalhes .= $pagamento_nome.'<br>';
            }
        }

        $registros_grade_status_dados[] = [
            'status_cor' => $status_cor,
            'status' => $status,
            'detalhes' => $detalhes
        ];
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Verificar Configurações : se existe para a referência'''''''''''''''''
        //Colunas
        if ($configuracoes->count() == 1) {
            $status_cor = 'success';
            $status = 'Quantidade de Configurações Ok';
        } else {
            //Variáveis de Controle''''''''
            $re_status_dados = 0;
            $re_status_dados_texto = 'Dados Falhou.';
            //'''''''''''''''''''''''''''''

            $status_cor = 'danger';
            $status = 'Não existem registros de Configurações';
        }

        $detalhes = '';

        $registros_grade_status_dados[] = [
            'status_cor' => $status_cor,
            'status' => $status,
            'detalhes' => $detalhes
        ];
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Verificar Configurações : se existem dados incompletos''''''''''''''''
        //Colunas
        if ($configuracoes->count() == 1) {
            $status_cor = 'success';
            $status = 'Dados de Configurações completos';
        } else {
            //Variáveis de Controle''''''''
            $re_status_dados = 0;
            $re_status_dados_texto = 'Dados Falhou.';
            //'''''''''''''''''''''''''''''

            $status_cor = 'danger';
            $status = 'Não existem registros de Configurações';
        }

        $detalhes = '';

        //Varrer militares
        foreach ($configuracoes as $configuracao) {
            $configuracao_referencia = SuporteFacade::getReferencia(1, $configuracao['referencia']);

            if ($configuracao['data_vencimento'] == '' or $configuracao['data_vencimento'] === null
                or $configuracao['diretor_identidade_funcional'] == '' or $configuracao['diretor_identidade_funcional'] === null
                or $configuracao['diretor_rg'] == '' or $configuracao['diretor_rg'] === null
                or $configuracao['diretor_nome'] == '' or $configuracao['diretor_nome'] === null
                or $configuracao['diretor_posto'] == '' or $configuracao['diretor_posto'] === null
                or $configuracao['diretor_quadro'] == '' or $configuracao['diretor_quadro'] === null
                or $configuracao['diretor_cargo'] == '' or $configuracao['diretor_cargo'] === null
                or $configuracao['dgf2_identidade_funcional'] == '' or $configuracao['dgf2_identidade_funcional'] === null
                or $configuracao['dgf2_rg'] == '' or $configuracao['dgf2_rg'] === null
                or $configuracao['dgf2_nome'] == '' or $configuracao['dgf2_nome'] === null
                or $configuracao['dgf2_posto'] == '' or $configuracao['dgf2_posto'] === null
                or $configuracao['dgf2_quadro'] == '' or $configuracao['dgf2_quadro'] === null
                or $configuracao['dgf2_cargo'] == '' or $configuracao['diretor_cargo'] === null) {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                //Colunas
                $status_cor = 'danger';
                $status = 'Existem registros de Configurações incompletos';
                $detalhes .= $configuracao_referencia.'<br>';
            }
        }

        $registros_grade_status_dados[] = [
            'status_cor' => $status_cor,
            'status' => $status,
            'detalhes' => $detalhes
        ];
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Grade de Status dos Dados - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Grade de Status dos Dados - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Grade de Status dos Documentos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Grade de Status dos Documentos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Array para guardar dados da grade de Status dos Documentos
        $registros_grade_status_documentos = array(); //colunas: Status / Detalhes

        //Variáveis de Controle''''''''
        $re_status_documentos = 1;
        $re_status_documentos_texto = 'Documentos Ok.';
        //'''''''''''''''''''''''''''''

        //Verificar Dados Cobranças : se existe para todos os Militares'''''''''
        //Colunas
        if ($militares->count() == $cobrancas_dados->count()) {
            $status_cor = 'success';
            $status = 'Quantidade de Dados Ok';
        } else {
            //Variáveis de Controle''''''''
            $re_status_documentos = 0;
            $re_status_documentos_texto = 'Documentos Falhou.';
            //'''''''''''''''''''''''''''''

            if ($cobrancas_dados->count() == 0) {
                $status_cor = 'danger';
                $status = 'Não existem registros de Cobrança';
            } else {
                $status_cor = 'danger';
                $status = 'Quantidade de registros de Cobrança';
            }
        }

        $detalhes = '';

        //Varrer militares
        foreach ($militares as $militar) {
            $identidade_funcional = $militar['identidade_funcional'];
            $militar_nome = $militar['nome'];
            $identidade_funcional_encontrada = false;

            foreach ($cobrancas_dados as $cobrancas_dado) {
                if ($cobrancas_dado['militar_identidade_funcional'] == $identidade_funcional) {
                    $identidade_funcional_encontrada = true;
                    break;
                }
            }

            if ($identidade_funcional_encontrada === false) {
                //Variáveis de Controle''''''''
                $re_status_documentos = 0;
                $re_status_documentos_texto = 'Documentos Falhou.';
                //'''''''''''''''''''''''''''''

                //Colunas
                $status_cor = 'danger';
                $status = 'Existem Militares sem registro de Cobrança';
                $detalhes .= $militar_nome.'<br>';
            }
        }

        $registros_grade_status_documentos[] = [
            'status_cor' => $status_cor,
            'status' => $status,
            'detalhes' => $detalhes
        ];
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Verificar Dados PDFs Listagens''''''''''''''''''''''''''''''''''''''''
        //Colunas
        if ($orgaos->count() == $cobrancas_pdfs_listagens->count()) {
            $status_cor = 'success';
            $status = 'Quantidade de Listagens Ok';
        } else {
            //Variáveis de Controle''''''''
            $re_status_documentos = 0;
            $re_status_documentos_texto = 'Documentos Falhou.';
            //'''''''''''''''''''''''''''''

            if ($cobrancas_pdfs_listagens->count() == 0) {
                $status_cor = 'danger';
                $status = 'Não existem registros de Listagens';
            } else {
                $status_cor = 'danger';
                $status = 'Quantidade de registros de Listagens';
            }
        }

        $detalhes = '';

        //Varrer Orgaos
        foreach ($orgaos as $orgao) {
            $orgao_id = $orgao['id'];
            $orgao_nome = $orgao['name'];
            $orgao_encontrado = false;

            foreach ($cobrancas_pdfs_listagens as $cobrancas_pdfs_listagem) {
                if ($cobrancas_pdfs_listagem['ressarcimento_orgao_id'] == $orgao_id) {
                    $orgao_encontrado = true;
                    break;
                }
            }

            if ($orgao_encontrado === false) {
                //Variáveis de Controle''''''''
                $re_status_documentos = 0;
                $re_status_documentos_texto = 'Documentos Falhou.';
                //'''''''''''''''''''''''''''''

                //Colunas
                $status_cor = 'danger';
                $status = 'Existem Órgãos sem registro de Listagens';
                $detalhes .= $orgao_nome.'<br>';
            }
        }

        $registros_grade_status_documentos[] = [
            'status_cor' => $status_cor,
            'status' => $status,
            'detalhes' => $detalhes
        ];
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Verificar Dados PDFs Notas''''''''''''''''''''''''''''''''''''''''''''
        //Colunas
        if ($orgaos->count() == $cobrancas_pdfs_notas->count()) {
            $status_cor = 'success';
            $status = 'Quantidade de Notas Ok';
        } else {
            //Variáveis de Controle''''''''
            $re_status_documentos = 0;
            $re_status_documentos_texto = 'Documentos Falhou.';
            //'''''''''''''''''''''''''''''

            if ($cobrancas_pdfs_notas->count() == 0) {
                $status_cor = 'danger';
                $status = 'Não existem registros de Notas';
            } else {
                $status_cor = 'danger';
                $status = 'Quantidade de registros de Notas';
            }
        }

        $detalhes = '';

        //Varrer Orgaos
        foreach ($orgaos as $orgao) {
            $orgao_id = $orgao['id'];
            $orgao_nome = $orgao['name'];
            $orgao_encontrado = false;

            foreach ($cobrancas_pdfs_notas as $cobrancas_pdfs_nota) {
                if ($cobrancas_pdfs_nota['ressarcimento_orgao_id'] == $orgao_id) {
                    $orgao_encontrado = true;
                    break;
                }
            }

            if ($orgao_encontrado === false) {
                //Variáveis de Controle''''''''
                $re_status_documentos = 0;
                $re_status_documentos_texto = 'Documentos Falhou.';
                //'''''''''''''''''''''''''''''

                //Colunas
                $status_cor = 'danger';
                $status = 'Existem Órgãos sem registro de Notas';
                $detalhes .= $orgao_nome.'<br>';
            }
        }

        $registros_grade_status_documentos[] = [
            'status_cor' => $status_cor,
            'status' => $status,
            'detalhes' => $detalhes
        ];
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Verificar Dados PDFs Oficios''''''''''''''''''''''''''''''''''''''''''
        //Colunas
        if ($orgaos->count() == $cobrancas_pdfs_oficios->count()) {
            $status_cor = 'success';
            $status = 'Quantidade de Ofícios Ok';
        } else {
            //Variáveis de Controle''''''''
            $re_status_documentos = 0;
            $re_status_documentos_texto = 'Documentos Falhou.';
            //'''''''''''''''''''''''''''''

            if ($cobrancas_pdfs_oficios->count() == 0) {
                $status_cor = 'danger';
                $status = 'Não existem registros de Ofícios';
            } else {
                $status_cor = 'danger';
                $status = 'Quantidade de registros de Ofícios';
            }
        }

        $detalhes = '';

        //Varrer Orgaos
        foreach ($orgaos as $orgao) {
            $orgao_id = $orgao['id'];
            $orgao_nome = $orgao['name'];
            $orgao_encontrado = false;

            foreach ($cobrancas_pdfs_oficios as $cobrancas_pdfs_oficio) {
                if ($cobrancas_pdfs_oficio['ressarcimento_orgao_id'] == $orgao_id) {
                    $orgao_encontrado = true;
                    break;
                }
            }

            if ($orgao_encontrado === false) {
                //Variáveis de Controle''''''''
                $re_status_documentos = 0;
                $re_status_documentos_texto = 'Documentos Falhou.';
                //'''''''''''''''''''''''''''''

                //Colunas
                $status_cor = 'danger';
                $status = 'Existem Órgãos sem registro de Ofícios';
                $detalhes .= $orgao_nome.'<br>';
            }
        }

        $registros_grade_status_documentos[] = [
            'status_cor' => $status_cor,
            'status' => $status,
            'detalhes' => $detalhes
        ];
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Grade de Status dos Documentos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Grade de Status dos Documentos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Html''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $content['re_referencia'] = SuporteFacade::getReferencia(1, $referencia);
        $content['re_orgaos'] = $orgaos;
        $content['re_configuracoes'] = $configuracoes;
        $content['re_quantidade_orgaos'] = $orgaos->count();
        $content['re_quantidade_militares'] = $militares->count();
        $content['re_quantidade_pagamentos'] = $pagamentos->count();
        $content['re_quantidade_configuracoes'] = $configuracoes->count();
        $content['re_quantidade_cobranca'] = $cobrancas_dados->count();
        $content['re_quantidade_listagens'] = $cobrancas_pdfs_listagens->count();
        $content['re_quantidade_notas'] = $cobrancas_pdfs_notas->count();
        $content['re_quantidade_oficios'] = $cobrancas_pdfs_oficios->count();
        $content['re_status_dados'] = $re_status_dados;
        $content['re_status_dados_texto'] = $re_status_dados_texto;
        $content['re_registros_grade_status_dados'] = $registros_grade_status_dados;
        $content['re_status_documentos'] = $re_status_documentos;
        $content['re_status_documentos_texto'] = $re_status_documentos_texto;
        $content['re_registros_grade_status_documentos'] = $registros_grade_status_documentos;
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        return $this->sendResponse('Dados enviados com sucesso.', 2000, null, $content);
    }

    /*
     * Gera dados de Cobranças e Retorna dados para o Client
     */
    public function gerar_cobrancas($referencia)
    {
        //Array de retorno
        $content = array();

        //Variaveis
        $total_listagens = 0;
        $total_oficios = 0;
        $total_notas = 0;

        //Apagando dados de Cobrança caso tenha e refazer
        SuporteFacade::delCobranca($referencia);

        //Array de dados
        $data = array();

        //Gravando registros tabela ressarcimento_cobrancas - INICIO''''''''''''''''''''''''''''''''''''''''''''''''''''
        RessarcimentoCobranca::create([
            'referencia' => $referencia,
            'cobranca_encerrada' => 0
        ]);
        //Gravando registros tabela ressarcimento_cobrancas - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Pegando dado na Tabela: ressarcimento_referencias - INICIO''''''''''''''''''''''''''''''''''''''''''''''''''''
        $reg_referencia = RessarcimentoReferencia::where('referencia', $referencia)->get()[0];

        $data['ressarcimento_referencia_id'] = $reg_referencia['id'];
        $data['referencia'] = $reg_referencia['referencia'];
        $data['referencia_ano'] = $reg_referencia['ano'];
        $data['referencia_mes'] = $reg_referencia['mes'];
        $data['referencia_parte'] = $reg_referencia['parte'];
        //Pegando dado na Tabela: ressarcimento_referencias - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Pegando dado na Tabela: ressarcimento_configuracoes - INICIO''''''''''''''''''''''''''''''''''''''''''''''''''
        $reg_configuracoes = RessarcimentoConfiguracao::where('referencia', $referencia)->get()[0];

        $data['configuracao_data_vencimento'] = $reg_configuracoes['data_vencimento'];
        $data['configuracao_diretor_identidade_funcional'] = $reg_configuracoes['diretor_identidade_funcional'];
        $data['configuracao_diretor_rg'] = $reg_configuracoes['diretor_rg'];
        $data['configuracao_diretor_nome'] = $reg_configuracoes['diretor_nome'];
        $data['configuracao_diretor_posto'] = $reg_configuracoes['diretor_posto'];
        $data['configuracao_diretor_quadro'] = $reg_configuracoes['diretor_quadro'];
        $data['configuracao_diretor_cargo'] = $reg_configuracoes['diretor_cargo'];
        $data['configuracao_dgf2_identidade_funcional'] = $reg_configuracoes['dgf2_identidade_funcional'];
        $data['configuracao_dgf2_rg'] = $reg_configuracoes['dgf2_rg'];
        $data['configuracao_dgf2_nome'] = $reg_configuracoes['dgf2_nome'];
        $data['configuracao_dgf2_posto'] = $reg_configuracoes['dgf2_posto'];
        $data['configuracao_dgf2_quadro'] = $reg_configuracoes['dgf2_quadro'];
        $data['configuracao_dgf2_cargo'] = $reg_configuracoes['dgf2_cargo'];
        //Pegando dado na Tabela: ressarcimento_configuracoes - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Varrer Tabela : ressarcimento_orgaos - INICIO'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $reg_orgaos = RessarcimentoOrgao
            ::join('ressarcimento_militares', 'ressarcimento_militares.lotacao_id', 'ressarcimento_orgaos.lotacao_id')
            ->join('esferas', 'esferas.id', 'ressarcimento_orgaos.esfera_id')
            ->join('poderes', 'poderes.id', 'ressarcimento_orgaos.poder_id')
            ->join('tratamentos', 'tratamentos.id', 'ressarcimento_orgaos.tratamento_id')
            ->join('vocativos', 'vocativos.id', 'ressarcimento_orgaos.vocativo_id')
            ->join('funcoes', 'funcoes.id', 'ressarcimento_orgaos.funcao_id')
            ->select('ressarcimento_orgaos.*', 'esferas.name as esferaName', 'poderes.name as poderName', 'tratamentos.completo as tratamentoCompleto', 'tratamentos.reduzido as tratamentoReduzido', 'vocativos.name as vocativoName', 'funcoes.name as funcaoName')
            ->distinct()
            ->where('ressarcimento_orgaos.realizar_cobranca', 1)
            ->where('ressarcimento_militares.referencia', $referencia)
            ->get();

        foreach ($reg_orgaos as $reg_orgao) {
            $data['ressarcimento_orgao_id'] = $reg_orgao['id'];
            $data['orgao_name'] = $reg_orgao['name'];
            $data['orgao_cnpj'] = $reg_orgao['cnpj'];
            $data['orgao_ug'] = $reg_orgao['ug'];
            $data['orgao_destinatario_pequeno'] = $reg_orgao['name'];
            $data['orgao_destinatario_grande'] = $reg_orgao['funcaoName'].' '.$reg_orgao['name'];
            $data['orgao_responsavel'] = $reg_orgao['responsavel'];
            $data['orgao_telefone_1'] = $reg_orgao['telefone_1'];
            $data['orgao_telefone_2'] = $reg_orgao['telefone_2'];
            $data['orgao_cep'] = $reg_orgao['cep'];
            $data['orgao_numero'] = $reg_orgao['numero'];
            $data['orgao_complemento'] = $reg_orgao['complemento'];
            $data['orgao_logradouro'] = $reg_orgao['logradouro'];
            $data['orgao_bairro'] = $reg_orgao['bairro'];
            $data['orgao_localidade'] = $reg_orgao['localidade'];
            $data['orgao_uf'] = $reg_orgao['uf'];
            $data['orgao_contato_nome'] = $reg_orgao['contato_nome'];
            $data['orgao_contato_telefone'] = $reg_orgao['contato_telefone'];
            $data['orgao_contato_celular'] = $reg_orgao['contato_celular'];
            $data['orgao_contato_email'] = $reg_orgao['contato_email'];
            $data['orgao_esfera'] = $reg_orgao['esferaName'];
            $data['orgao_poder'] = $reg_orgao['poderName'];
            $data['orgao_tratamento_completo'] = $reg_orgao['tratamentoCompleto'];
            $data['orgao_tratamento_reduzido'] = $reg_orgao['tratamentoReduzido'];
            $data['orgao_vocativo'] = $reg_orgao['vocativoName'];
            $data['orgao_funcao'] = $reg_orgao['funcaoName'];

            //Gravando registros tabela ressarcimento_cobrancas_pdfs_listagens - INICIO'''''''''''''''''''''''''''''''''
            $anoNumeroNota = SuporteFacade::getAnoNumeroNota();

            $nota_numero = substr($anoNumeroNota, 4);
            $nota_ano = substr($anoNumeroNota, 0, 4);

            $ressarcimento_cobranca_pdf_listagem = RessarcimentoCobrancaPdfListagem::create([
                'ressarcimento_orgao_id' => $data['ressarcimento_orgao_id'],
                'referencia' => $data['referencia'],
                'referencia_ano' => $data['referencia_ano'],
                'referencia_mes' => $data['referencia_mes'],
                'referencia_parte' => $data['referencia_parte'],
                'orgao_name' => $data['orgao_name'],
                'configuracao_dgf2_identidade_funcional' => $data['configuracao_dgf2_identidade_funcional'],
                'configuracao_dgf2_rg' => $data['configuracao_dgf2_rg'],
                'configuracao_dgf2_nome' => $data['configuracao_dgf2_nome'],
                'configuracao_dgf2_posto' => $data['configuracao_dgf2_posto'],
                'configuracao_dgf2_quadro' => $data['configuracao_dgf2_quadro'],
                'configuracao_dgf2_cargo' => $data['configuracao_dgf2_cargo'],
                'nota_numero' => $nota_numero,
                'nota_ano' => $nota_ano,
                'oe_cobrar' => ''
            ]);

            $total_listagens++;

            //pegando id da inclusao acima
            $ressarcimento_cobranca_pdf_listagem_id = $ressarcimento_cobranca_pdf_listagem['id'];
            //Gravando registros tabela ressarcimento_cobrancas_pdfs_listagens - FIM''''''''''''''''''''''''''''''''''''

            //Zerando dados para gravar na tabela ressarcimento_cobrancas_pdfs_notas - INICIO'''''''''''''''''''''''''''
            $nota_total_militares = 0;
            $nota_valor_recursos_oriundos_fonte100 = 0;
            $nota_valor_recursos_oriundos_fonte232 = 0;
            $nota_valor_bruto_folha_suplementar = 0;
            $nota_valor_rioprevidencia = 0;
            $nota_valor_fundo_saude = 0;
            $nota_valor_total = 0;
            //Zerando dados para gravar na tabela ressarcimento_cobrancas_pdfs_notas - FIM''''''''''''''''''''''''''''''

            //Varrer Tabela : ressarcimento_militares - INICIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $reg_militares = RessarcimentoMilitar::where('lotacao_id', $reg_orgao['lotacao_id'])->where('referencia', $referencia)->get();

            foreach ($reg_militares as $reg_militar) {
                $nota_total_militares++;

                $data['ressarcimento_militar_id'] = $reg_militar['id'];
                $data['militar_identidade_funcional'] = $reg_militar['identidade_funcional'];
                $data['militar_rg'] = $reg_militar['rg'];
                $data['militar_nome'] = $reg_militar['nome'];
                $data['militar_posto_graduacao'] = $reg_militar['posto_graduacao'];
                $data['militar_quadro_qbmp'] = $reg_militar['quadro_qbmp'];
                $data['militar_boletim'] = $reg_militar['boletim'];
                $data['militar_lotacao_id'] = $reg_militar['lotacao_id'];
                $data['militar_lotacao'] = $reg_militar['lotacao'];

                //Varrer Tabela : ressarcimento_pagamentos - INICIO'''''''''''''''''''''''''''''''''''''''''''''''''''''
                $reg_pagamentos = RessarcimentoPagamento::where('identidade_funcional', $reg_militar['identidade_funcional'])->where('referencia', $referencia)->get();

                foreach ($reg_pagamentos as $reg_pagamento) {
                    $data['ressarcimento_pagamento_id'] = $reg_pagamento['id'];

                    $data['pagamento_bruto'] = SuporteFacade::getValorFormatado(1, $reg_pagamento['bruto']);
                    $data['pagamento_etapa_ferias'] = SuporteFacade::getValorFormatado(1, $reg_pagamento['etapa_ferias']);
                    $data['pagamento_etapa_destacado'] = SuporteFacade::getValorFormatado(1, $reg_pagamento['etapa_destacado']);
                    $data['pagamento_fundo_saude'] = SuporteFacade::getValorFormatado(1, $reg_pagamento['fundo_saude']);
                    $data['pagamento_rioprevidencia22'] = SuporteFacade::getValorFormatado(1, $reg_pagamento['rioprevidencia22']);

                    //dados para gravar na tabela ressarcimento_cobrancas_pdfs_listagens''''''''''''''''''''''''''''''''
                    $listagem_fonte10 = $data['pagamento_etapa_ferias'] + $data['pagamento_etapa_destacado'];
                    $listagem_vencimento_bruto = $data['pagamento_bruto'] - $listagem_fonte10;
                    $listagem_fundo_saude_10 = $data['pagamento_fundo_saude'];
                    $listagem_rioprevidencia22 = $data['pagamento_rioprevidencia22'];
                    $listagem_folha_suplementar = 0;
                    $listagem_valor_total = $listagem_vencimento_bruto + $listagem_fundo_saude_10 + $listagem_rioprevidencia22 + $listagem_fonte10 + $listagem_folha_suplementar;
                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                    //dados para gravar na tabela ressarcimento_cobrancas_pdfs_notas''''''''''''''''''''''''''''''''''''
                    $nota_valor_recursos_oriundos_fonte100 += $listagem_fonte10;
                    $nota_valor_recursos_oriundos_fonte232 += $listagem_vencimento_bruto;
                    $nota_valor_bruto_folha_suplementar += $listagem_folha_suplementar;
                    $nota_valor_rioprevidencia += $listagem_rioprevidencia22;
                    $nota_valor_fundo_saude += $listagem_fundo_saude_10;
                    $nota_valor_total += $listagem_valor_total;
                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                    //Dados da listagem para gravar na ressarcimento_cobrancas_dados''''''''''''''''''''''''''''''''''''
                    $data['listagem_fonte10'] = $listagem_fonte10;
                    $data['listagem_vencimento_bruto'] = $listagem_vencimento_bruto;
                    $data['listagem_fundo_saude_10'] = $listagem_fundo_saude_10;
                    $data['listagem_rioprevidencia22'] = $listagem_rioprevidencia22;
                    $data['listagem_folha_suplementar'] = $listagem_folha_suplementar;
                    $data['listagem_valor_total'] = $listagem_valor_total;
                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                    //Gravando registros tabela ressarcimento_cobrancas_dados'''''''''''''''''''''''''''''''''''''''''''
                    $ressarcimento_cobranca_dado = RessarcimentoCobrancaDado::create($data);

                    //pegando id da inclusao acima
                    $ressarcimento_cobranca_dado_id = $ressarcimento_cobranca_dado['id'];
                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                    //Gravando registros tabela ressarcimento_recebimentos - INICIO'''''''''''''''''''''''''''''''''''''
                    RessarcimentoRecebimento::create([
                        'ressarcimento_cobranca_dado_id' => $ressarcimento_cobranca_dado_id,
                        'valor_recebido' => 0,
                        'saldo_restante' => 0
                    ]);
                    //Gravando registros tabela ressarcimento_recebimentos - FIM''''''''''''''''''''''''''''''''''''''''

                    //Gravando registros tabela ressarcimento_cobrancas_pdfs_listagens_dados''''''''''''''''''''''''''''
                    RessarcimentoCobrancaPdfListagemDado::create([
                        'ressarcimento_cobranca_pdf_listagem_id' => $ressarcimento_cobranca_pdf_listagem_id,
                        'militar_identidade_funcional' => $data['militar_identidade_funcional'],
                        'militar_posto_graduacao' => $data['militar_posto_graduacao'],
                        'militar_nome' => $data['militar_nome'],
                        'vencimento_bruto' => $listagem_vencimento_bruto,
                        'fundo_saude_10' => $listagem_fundo_saude_10,
                        'rioprevidencia22' => $listagem_rioprevidencia22,
                        'fonte10' => $listagem_fonte10,
                        'folha_suplementar' => $listagem_folha_suplementar,
                        'valor_total' => $listagem_valor_total
                    ]);
                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                }
                //Varrer Tabela : ressarcimento_pagamentos - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            }
            //Varrer Tabela : ressarcimento_militares - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Gravando registros tabela ressarcimento_cobrancas_pdfs_oficios - INICIO'''''''''''''''''''''''''''''''''''
            $anoNumeroOficio = SuporteFacade::getAnoNumeroOficio();

            $oficio_numero = substr($anoNumeroOficio, 4);
            $oficio_ano = substr($anoNumeroOficio, 0, 4);

            RessarcimentoCobrancaPdfOficio::create([
                'ressarcimento_orgao_id' => $data['ressarcimento_orgao_id'],
                'referencia' => $data['referencia'],
                'referencia_ano' => $data['referencia_ano'],
                'referencia_mes' => $data['referencia_mes'],
                'referencia_parte' => $data['referencia_parte'],
                'oficio_numero' => $oficio_numero,
                'oficio_ano' => $oficio_ano,
                'orgao_name' => $data['orgao_name'],
                'orgao_cnpj' => $data['orgao_cnpj'],
                'orgao_ug' => $data['orgao_ug'],
                'orgao_destinatario_pequeno' => $data['orgao_name'],
                'orgao_destinatario_grande' => $data['orgao_funcao'].' '.$data['orgao_name'],
                'orgao_responsavel' => $data['orgao_responsavel'],
                'orgao_esfera' => $data['orgao_esfera'],
                'orgao_poder' => $data['orgao_poder'],
                'orgao_tratamento_completo' => $data['orgao_tratamento_completo'],
                'orgao_tratamento_reduzido' => $data['orgao_tratamento_reduzido'],
                'orgao_vocativo' => $data['orgao_vocativo'],
                'orgao_funcao' => $data['orgao_funcao'],
                'orgao_telefone_1' => $data['orgao_telefone_1'],
                'orgao_telefone_2' => $data['orgao_telefone_2'],
                'orgao_cep' => $data['orgao_cep'],
                'orgao_numero' => $data['orgao_numero'],
                'orgao_complemento' => $data['orgao_complemento'],
                'orgao_logradouro' => $data['orgao_logradouro'],
                'orgao_bairro' => $data['orgao_bairro'],
                'orgao_localidade' => $data['orgao_localidade'],
                'orgao_uf' => $data['orgao_uf'],
                'orgao_contato_nome' => $data['orgao_contato_nome'],
                'orgao_contato_telefone' => $data['orgao_contato_telefone'],
                'orgao_contato_celular' => $data['orgao_contato_celular'],
                'orgao_contato_email' => $data['orgao_contato_email'],
                'configuracao_data_vencimento' => $data['configuracao_data_vencimento'],
                'configuracao_diretor_identidade_funcional' => $data['configuracao_diretor_identidade_funcional'],
                'configuracao_diretor_rg' => $data['configuracao_diretor_rg'],
                'configuracao_diretor_nome' => $data['configuracao_diretor_nome'],
                'configuracao_diretor_posto' => $data['configuracao_diretor_posto'],
                'configuracao_diretor_quadro' => $data['configuracao_diretor_quadro'],
                'configuracao_diretor_cargo' => $data['configuracao_diretor_cargo']
            ]);

            $total_oficios++;
            //Gravando registros tabela ressarcimento_cobrancas_pdfs_oficios - FIM''''''''''''''''''''''''''''''''''''''

            //Gravando registros tabela ressarcimento_cobrancas_pdfs_notas - INICIO'''''''''''''''''''''''''''''''''''''
            RessarcimentoCobrancaPdfNota::create([
                'ressarcimento_orgao_id' => $data['ressarcimento_orgao_id'],
                'referencia' => $data['referencia'],
                'referencia_ano' => $data['referencia_ano'],
                'referencia_mes' => $data['referencia_mes'],
                'referencia_parte' => $data['referencia_parte'],
                'orgao_name' => $data['orgao_name'],
                'configuracao_data_vencimento' => $data['configuracao_data_vencimento'],
                'configuracao_diretor_identidade_funcional' => $data['configuracao_diretor_identidade_funcional'],
                'configuracao_diretor_rg' => $data['configuracao_diretor_rg'],
                'configuracao_diretor_nome' => $data['configuracao_diretor_nome'],
                'configuracao_diretor_posto' => $data['configuracao_diretor_posto'],
                'configuracao_diretor_quadro' => $data['configuracao_diretor_quadro'],
                'configuracao_diretor_cargo' => $data['configuracao_diretor_cargo'],
                'oficio_numero' => $oficio_numero,
                'oficio_ano' => $oficio_ano,
                'total_militares' => $nota_total_militares,
                'valor_recursos_oriundos_fonte100' => $nota_valor_recursos_oriundos_fonte100,
                'valor_recursos_oriundos_fonte232' => $nota_valor_recursos_oriundos_fonte232,
                'valor_bruto_folha_suplementar' => $nota_valor_bruto_folha_suplementar,
                'valor_rioprevidencia' => $nota_valor_rioprevidencia,
                'valor_fundo_saude' => $nota_valor_fundo_saude,
                'valor_total' => $nota_valor_total
            ]);

            $total_notas++;
            //Gravando registros tabela ressarcimento_cobrancas_pdfs_notas - FIM''''''''''''''''''''''''''''''''''''''''
        }
        //Varrer Tabela : ressarcimento_orgaos - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Array para guardar o passo-a-passo da operação de Gerar Cobrança para gravar no Log de Transações'''''''''''''
        $arrayTransacoes = array();
        $arrayTransacoes[] = 'Apagado Cobrança para a referência.';
        $arrayTransacoes[] = 'Criado 1 registro de Cobrança.';
        $arrayTransacoes[] = 'Criado '.$total_listagens.' Registros de Listagens.';
        $arrayTransacoes[] = 'Criado '.$total_oficios.' Registros de Ofícios.';
        $arrayTransacoes[] = 'Criado '.$total_notas.' Registros de Notas.';
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //retorno
        $content['transacoes'] = $arrayTransacoes;

        return $this->sendResponse('Dados enviados com sucesso.', 2000, null, $content);
    }

    /*
     * Gerar PDFs: Retorna dados para o Client
     */
    public function gerar_pdfs($referencia)
    {
        //Dados para gerar PDF Listagem
        $cobranca_pdfs_listagens = RessarcimentoCobrancaPdfListagem::where('referencia', $referencia)->get();
        $cobranca_pdfs_listagens_dados = RessarcimentoCobrancaPdfListagem
            ::join('ressarcimento_cobrancas_pdfs_listagens_dados', 'ressarcimento_cobrancas_pdfs_listagens_dados.ressarcimento_cobranca_pdf_listagem_id', 'ressarcimento_cobrancas_pdfs_listagens.id')
            ->select('ressarcimento_cobrancas_pdfs_listagens_dados.*')
            ->where('ressarcimento_cobrancas_pdfs_listagens.referencia', $referencia)
            ->get();

        //Dados para gerar PDFs Ofícios
        $cobranca_pdfs_oficios = RessarcimentoCobrancaPdfOficio::where('referencia', $referencia)->get();

        //Dados para gerar PDFs Notas
        $cobranca_pdfs_notas = RessarcimentoCobrancaPdfNota::where('referencia', $referencia)->get();

        //Array de retorno
        $content = array();

        $content['cobranca_pdfs_listagens'] = $cobranca_pdfs_listagens;
        $content['cobranca_pdfs_listagens_dados'] = $cobranca_pdfs_listagens_dados;
        $content['cobranca_pdfs_oficios'] = $cobranca_pdfs_oficios;
        $content['cobranca_pdfs_notas'] = $cobranca_pdfs_notas;

        return $this->sendResponse('Dados enviados com sucesso.', 2000, null, $content);
    }
}
