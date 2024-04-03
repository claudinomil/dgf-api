<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
use App\Models\RessarcimentoCobranca;
use App\Models\RessarcimentoConfiguracao;
use App\Models\RessarcimentoOrgao;
use App\Models\RessarcimentoReferencia;
use Illuminate\Http\Request;
use App\Models\RessarcimentoMilitar;
use Illuminate\Support\Facades\DB;

class RessarcimentoMilitarController extends Controller
{
    private $ressarcimento_militar;

    public function __construct(RessarcimentoMilitar $ressarcimento_militar)
    {
        $this->ressarcimento_militar = $ressarcimento_militar;
    }

    public function index()
    {
        $registros = $this->ressarcimento_militar->all();

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, null, $registros), 200);
    }

    public function show($id)
    {
        try {
            $registro = $this->ressarcimento_militar->find($id);

            if (!$registro) {
                return response()->json(ApiReturn::data('Registro não encontrado.', 4040, null, null), 404);
            } else {
                return response()->json(ApiReturn::data('Registro enviado com sucesso.', 2000, null, $registro), 200);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiReturn::data($e->getMessage(), 5000, null, null), 500);
            }

            return response()->json(ApiReturn::data('Houve um erro ao realizar a operação.', 5000, null, null), 500);
        }
    }

    public function auxiliary()
    {
        try {
            $registros = array();

            //Referências (com Cobranças abertas)'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Array para guardar as referencias para retorno
            $referencias = array();

            //varrer tabela ressarcimento_referencias
            $ressarcimento_referencias = RessarcimentoReferencia::orderby('referencia')->get();

            foreach ($ressarcimento_referencias as $ressarcimento_referencia) {
                if (RessarcimentoCobranca::where('cobranca_encerrada', 1)->where('referencia', $ressarcimento_referencia['referencia'])->count() == 0) {
                    array_push($referencias, ['referencia' => $ressarcimento_referencia['referencia']]);
                }
            }

            $registros['referencias'] = $referencias;
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            return response()->json(ApiReturn::data('Registro enviado com sucesso.', 2000, null, $registros), 200);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiReturn::data($e->getMessage(), 5000, null, null), 500);
            }

            return response()->json(ApiReturn::data('Houve um erro ao realizar a operação.', 5000, null, null), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $registro = $this->ressarcimento_militar->find($id);

            if (!$registro) {
                return response()->json(ApiReturn::data('Registro não encontrado.', 4040, null, $registro), 404);
            } else {
                //Verificar Lógica''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Não deixar excluir se Cobrança da Referência estiver fechada
                $cobrancaFechada = DB::table('ressarcimento_cobrancas')->where('cobranca_encerrada', 1)->where('referencia', $registro['referencia'])->count();

                if ($cobrancaFechada == 1) {
                    return response()->json(ApiReturn::data('Náo é possível excluir. Cobrança fechada para a referência: '.SuporteFacade::getReferencia(1, $registro['referencia']), 2040, null, null), 200);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela Pagamentos
                if (SuporteFacade::verificarRelacionamento('ressarcimento_pagamentos', 'ressarcimento_militar_id', $id) > 0) {
                    return response()->json(ApiReturn::data('Náo é possível excluir. Registro relacionado com Ressarcimento Pagamentos.', 2040, null, null), 200);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $registro->delete();

                return response()->json(ApiReturn::data('Registro excluído com sucesso.', 2000, null, null), 200);
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiReturn::data($e->getMessage(), 5000, null, null), 500);
            }

            return response()->json(ApiReturn::data('Houve um erro ao realizar a operação.', 5000, null, null), 500);
        }
    }

    public function filter($array_dados)
    {
        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();


        //Registros
        $registros = $this->ressarcimento_militar
            ->select(['ressarcimento_militares.*'])
            ->where(function($query) use($filtros) {
                //Variavel para controle
                $qtdFiltros = count($filtros) / 4;
                $indexCampo = 0;

                for($i=1; $i<=$qtdFiltros; $i++) {
                    //Valores do Filtro
                    $condicao = $filtros[$indexCampo];
                    $campo = $filtros[$indexCampo+1];
                    $operacao = $filtros[$indexCampo+2];
                    $dado = $filtros[$indexCampo+3];
                    $dado = str_replace('xxbarrayy', '/', $dado);

                    //Operações
                    if ($operacao == 1) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado.'%');} else {$query->orwhere($campo, 'like', '%'.$dado.'%');}
                    }
                    if ($operacao == 2) {
                        if ($condicao == 1) {$query->where($campo, '=', $dado);} else {$query->orwhere($campo, '=', $dado);}
                    }
                    if ($operacao == 3) {
                        if ($condicao == 1) {$query->where($campo, '>', $dado);} else {$query->orwhere($campo, '>', $dado);}
                    }
                    if ($operacao == 4) {
                        if ($condicao == 1) {$query->where($campo, '>=', $dado);} else {$query->orwhere($campo, '>=', $dado);}
                    }
                    if ($operacao == 5) {
                        if ($condicao == 1) {$query->where($campo, '<', $dado);} else {$query->orwhere($campo, '<', $dado);}
                    }
                    if ($operacao == 6) {
                        if ($condicao == 1) {$query->where($campo, '<=', $dado);} else {$query->orwhere($campo, '<=', $dado);}
                    }
                    if ($operacao == 7) {
                        if ($condicao == 1) {$query->where($campo, 'like', $dado.'%');} else {$query->orwhere($campo, 'like', $dado.'%');}
                    }
                    if ($operacao == 8) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado);} else {$query->orwhere($campo, 'like', '%'.$dado);}
                    }

                    //Atualizar indexCampo
                    $indexCampo = $indexCampo + 4;
                }
            }
            )->get();

        //Código SQL Bruto
        //$sql = DB::getQueryLog();

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, null, $registros), 200);
    }

    public function importar(Request $request)
    {
        try {
            //Verificar Lógica''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Não deixar importar se Cobrança da Referência estiver fechada
            $cobrancaFechada = DB::table('ressarcimento_cobrancas')->where('cobranca_encerrada', 1)->where('referencia', $request['referencia'])->count();

            if ($cobrancaFechada == 1) {
                return response()->json(ApiReturn::data('Náo é possível importar. Cobrança fechada para a referência: '.SuporteFacade::getReferencia(1, $request['referencia']), 2040, null, null), 200);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Array com Dados para inclusão
            $registro = array();

            $registro['referencia'] = utf8_decode($request['referencia']);
            $registro['identidade_funcional'] = utf8_decode(str_pad($request['identidade_funcional'], 10, '0', STR_PAD_LEFT));
            $registro['rg'] = utf8_decode($request['rg']);
            $registro['nome'] = utf8_decode($request['nome']);
            $registro['oficial_praca'] = utf8_decode($request['oficial_praca']);
            $registro['posto_graduacao'] = utf8_decode($request['posto_graduacao']);
            $registro['quadro_qbmp'] = utf8_decode($request['quadro_qbmp']);
            $registro['boletim'] = utf8_decode($request['boletim']);
            $registro['lotacao_id'] = utf8_decode($request['lotacao_id']);
            $registro['lotacao'] = utf8_decode($request['lotacao']);

            //Verificar se já foi importado
            $ja_importado = RessarcimentoMilitar::where('referencia', $registro['referencia'])->where('identidade_funcional', $registro['identidade_funcional'])->count();

            //Se não foi importado
            if ($ja_importado == 0) {
                //Incluindo registro
                $response = $this->ressarcimento_militar->create($registro);

                if ($response) {
                    //Gravar Órgão
                    $reg_existe = RessarcimentoOrgao::where('lotacao_id', $registro['lotacao_id'])->count();

                    if ($reg_existe == 1) {
                        RessarcimentoOrgao::where('lotacao_id', $registro['lotacao_id'])->update([
                            'lotacao' => $registro['lotacao']
                        ]);
                    } else {
                        $dados = array();
                        $dados['name'] = $registro['lotacao'];
                        $dados['lotacao_id'] = $registro['lotacao_id'];
                        $dados['lotacao'] = $registro['lotacao'];

                        RessarcimentoOrgao::create($dados);
                    }

                    //Gravar Configuração (um registro para a referência)
                    $reg_existe = RessarcimentoConfiguracao::where('referencia', $registro['referencia'])->count();

                    if ($reg_existe == 0) {
                        $registros_configuracoes = RessarcimentoConfiguracao::orderby('referencia', 'desc')->get();

                        if ($registros_configuracoes->count() > 0) {
                            foreach ($registros_configuracoes as $reg) {
                                $configuracoes = array();
                                $configuracoes['referencia'] = $registro['referencia'];
                                $configuracoes['data_vencimento'] = $reg['data_vencimento'];

                                $configuracoes['diretor_identidade_funcional'] = $reg['diretor_identidade_funcional'];
                                $configuracoes['diretor_rg'] = $reg['diretor_rg'];
                                $configuracoes['diretor_nome'] = $reg['diretor_nome'];
                                $configuracoes['diretor_posto'] = $reg['diretor_posto'];
                                $configuracoes['diretor_quadro'] = $reg['diretor_quadro'];
                                $configuracoes['diretor_cargo'] = $reg['diretor_cargo'];

                                $configuracoes['dgf2_identidade_funcional'] = $reg['dgf2_identidade_funcional'];
                                $configuracoes['dgf2_rg'] = $reg['dgf2_rg'];
                                $configuracoes['dgf2_nome'] = $reg['dgf2_nome'];
                                $configuracoes['dgf2_posto'] = $reg['dgf2_posto'];
                                $configuracoes['dgf2_quadro'] = $reg['dgf2_quadro'];
                                $configuracoes['dgf2_cargo'] = $reg['dgf2_cargo'];

                                break;
                            }
                        } else {
                            $configuracoes = array();
                            $configuracoes['referencia'] = $registro['referencia'];
                        }

                        RessarcimentoConfiguracao::create($configuracoes);
                    }

                    //Return
                    return response()->json(ApiReturn::data('Registro incluído com sucesso.', 2000, null, null), 200);
                } else {
                    return response()->json(ApiReturn::data($registro['nome'], 2005, null, null), 200);
                }
            } else {
                return response()->json(ApiReturn::data($registro['nome'], 2006, null, null), 200);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiReturn::data($registro['nome'].'<br>'.$e->getMessage(), 2005, null, null), 200);
            }

            return response()->json(ApiReturn::data($registro['nome'], 2005, null, null), 200);
        }
    }
}
