<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Http\Requests\RessarcimentoPagamentoUpdateRequest;
use App\Models\RessarcimentoCobranca;
use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoReferencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RessarcimentoPagamento;

class RessarcimentoPagamentoController extends Controller
{
    private $ressarcimento_pagamento;

    public function __construct(RessarcimentoPagamento $ressarcimento_pagamento)
    {
        $this->ressarcimento_pagamento = $ressarcimento_pagamento;
    }

    public function index()
    {
        $registros = $this->ressarcimento_pagamento
            ->leftJoin('ressarcimento_militares', function ($join) {
                $join->on('ressarcimento_pagamentos.referencia', '=', 'ressarcimento_militares.referencia')
                    ->on('ressarcimento_pagamentos.rg', '=', 'ressarcimento_militares.rg');
            })
            ->select('ressarcimento_pagamentos.*', 'ressarcimento_militares.lotacao')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->ressarcimento_pagamento->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(RessarcimentoPagamentoUpdateRequest $request, $id)
    {
        try {
            $registro = $this->ressarcimento_pagamento->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Verificar Lógica''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Não deixar alterar se Cobrança da Referência estiver fechada
                $cobrancaFechada = DB::table('ressarcimento_cobrancas')->where('cobranca_encerrada', 1)->where('referencia', $registro['referencia'])->count();

                if ($cobrancaFechada == 1) {
                    return $this->sendResponse('Náo é possível excluir. Cobrança fechada para a referência: '.SuporteFacade::getReferencia(1, $registro['referencia']), 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Alterando registro
                $registro->update($request->all());

                return $this->sendResponse('Registro atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
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
            $ressarcimento_referencias = RessarcimentoReferencia::all();

            foreach ($ressarcimento_referencias as $ressarcimento_referencia) {
                if (RessarcimentoCobranca::where('cobranca_encerrada', 1)->where('referencia', $ressarcimento_referencia['referencia'])->count() == 0) {
                    array_push($referencias, ['referencia' => $ressarcimento_referencia['referencia']]);
                }
            }

            $registros['referencias'] = $referencias;
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function destroy($id)
    {
        try {
            $registro = $this->ressarcimento_pagamento->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Lógica''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Não deixar excluir se Cobrança da Referência estiver fechada
                $cobrancaFechada = DB::table('ressarcimento_cobrancas')->where('cobranca_encerrada', 1)->where('referencia', $registro['referencia'])->count();

                if ($cobrancaFechada == 1) {
                    return $this->sendResponse('Náo é possível excluir. Cobrança fechada para a referência: '.SuporteFacade::getReferencia(1, $registro['referencia']), 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela Ressarcimento Cobrança Dados
                if (SuporteFacade::verificarRelacionamento('ressarcimento_cobrancas_dados', 'ressarcimento_pagamento_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado em Cobranças.', 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $registro->delete();

                return $this->sendResponse('Registro excluído com sucesso.', 2000, null, null);
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function filter($array_dados)
    {
        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();


        //Registros
        $registros = $this->ressarcimento_pagamento
            ->leftJoin('ressarcimento_militares', function ($join) {
                $join->on('ressarcimento_pagamentos.referencia', '=', 'ressarcimento_militares.referencia')
                    ->on('ressarcimento_pagamentos.rg', '=', 'ressarcimento_militares.rg');
            })
            ->select(['ressarcimento_pagamentos.*', 'ressarcimento_militares.lotacao'])
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

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function importar(Request $request)
    {
        try {
            //Verificar Lógica''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Não deixar importar se Cobrança da Referência estiver fechada
            $cobrancaFechada = DB::table('ressarcimento_cobrancas')->where('cobranca_encerrada', 1)->where('referencia', $request['referencia'])->count();

            if ($cobrancaFechada == 1) {
                return $this->sendResponse('Náo é possível importar. Cobrança fechada para a referência: '.SuporteFacade::getReferencia(1, $request['referencia']), 2040, null, null);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Array com Dados para inclusão
            $registro = array();

            $registro['ressarcimento_militar_id'] = utf8_decode($request['ressarcimento_militar_id']);
            $registro['referencia'] = utf8_decode($request['referencia']);
            $registro['identidade_funcional'] = utf8_decode(str_pad($request['identidade_funcional'], 10, '0', STR_PAD_LEFT));
            $registro['vinculo'] = utf8_decode($request['vinculo']);
            $registro['rg'] = utf8_decode($request['rg']);
            $registro['codigo_cargo'] = utf8_decode($request['codigo_cargo']);
            $registro['nome_cargo'] = utf8_decode($request['nome_cargo']);
            $registro['posto_graduacao'] = utf8_decode($request['posto_graduacao']);
            $registro['nivel'] = utf8_decode($request['nivel']);
            $registro['nome'] = utf8_decode($request['nome']);
            $registro['situacao_pagamento'] = utf8_decode($request['situacao_pagamento']);
            $registro['data_ingresso'] = utf8_decode($request['data_ingresso']);
            $registro['data_nascimento'] = utf8_decode($request['data_nascimento']);
            $registro['data_aposentadoria'] = utf8_decode($request['data_aposentadoria']);
            $registro['genero'] = utf8_decode($request['genero']);
            $registro['codigo_ua'] = utf8_decode($request['codigo_ua']);
            $registro['ua'] = $request['ua'];
            $registro['cpf'] = utf8_decode($request['cpf']);
            $registro['pasep'] = utf8_decode($request['pasep']);
            $registro['banco'] = utf8_decode($request['banco']);
            $registro['agencia'] = utf8_decode($request['agencia']);
            $registro['conta_corrente'] = utf8_decode($request['conta_corrente']);
            $registro['numero_dependentes'] = utf8_decode($request['numero_dependentes']);
            $registro['ir_dependente'] = utf8_decode($request['ir_dependente']);
            $registro['cotista'] = utf8_decode($request['cotista']);
            $registro['bruto'] = utf8_decode($request['bruto']);
            $registro['desconto'] = utf8_decode($request['desconto']);
            $registro['liquido'] = utf8_decode($request['liquido']);
            $registro['soldo'] = utf8_decode($request['soldo']);
            $registro['hospital10'] = utf8_decode($request['hospital10']);
            $registro['rioprevidencia22'] = utf8_decode($request['rioprevidencia22']);
            $registro['etapa_ferias'] = utf8_decode($request['etapa_ferias']);
            $registro['etapa_destacado'] = utf8_decode($request['etapa_destacado']);
            $registro['ajuda_fardamento'] = utf8_decode($request['ajuda_fardamento']);
            $registro['habilitacao_profissional'] = utf8_decode($request['habilitacao_profissional']);
            $registro['gret'] = utf8_decode($request['gret']);
            $registro['auxilio_moradia'] = utf8_decode($request['auxilio_moradia']);
            $registro['gpe'] = utf8_decode($request['gpe']);
            $registro['gee_capacitacao'] = utf8_decode($request['gee_capacitacao']);
            $registro['decreto14407'] = utf8_decode($request['decreto14407']);
            $registro['ferias'] = utf8_decode($request['ferias']);
            $registro['raio_x'] = utf8_decode($request['raio_x']);
            $registro['trienio'] = utf8_decode($request['trienio']);
            $registro['auxilio_invalidez'] = utf8_decode($request['auxilio_invalidez']);
            $registro['tempo_certo'] = utf8_decode($request['tempo_certo']);
            $registro['fundo_saude'] = utf8_decode($request['fundo_saude']);
            $registro['abono_permanencia'] = utf8_decode($request['abono_permanencia']);
            $registro['deducao_ir'] = utf8_decode($request['deducao_ir']);
            $registro['ir_valor'] = utf8_decode($request['ir_valor']);
            $registro['auxilio_transporte'] = utf8_decode($request['auxilio_transporte']);
            $registro['gram'] = utf8_decode($request['gram']);
            $registro['auxilio_fardamento'] = utf8_decode($request['auxilio_fardamento']);
            $registro['cidade'] = utf8_decode($request['cidade']);

            //Verificar se já foi importado
            $ja_importado = RessarcimentoPagamento::where('referencia', $registro['referencia'])->where('identidade_funcional', $registro['identidade_funcional'])->count();

            //Se não foi importado
            if ($ja_importado == 0) {
                //Incluindo registro
                $response = $this->ressarcimento_pagamento->create($registro);

                if ($response) {
                    return $this->sendResponse('Registro incluído com sucesso.', 2000, null, null);
                } else {
                    return $this->sendResponse($registro['nome'], 2005, null, null);
                }
            } else {
                return $this->sendResponse($registro['nome'], 2006, null, null);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($registro['nome'].'<br>'.$e->getMessage(), 2005, null, null);
            }

            return $this->sendResponse($registro['nome'], 2005, null, null);
        }
    }

    public function referencia_militares_ids_func($referencia)
    {
        $registros = RessarcimentoMilitar::where('referencia', $referencia)->select('id', 'identidade_funcional')->get();

        return $this->sendResponse('', 2000, null, $registros);
    }
}
