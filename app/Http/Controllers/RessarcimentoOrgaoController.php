<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Http\Requests\RessarcimentoOrgaoStoreRequest;
use App\Http\Requests\RessarcimentoOrgaoUpdateRequest;
use App\Models\Esfera;
use App\Models\Funcao;
use App\Models\Poder;
use App\Models\Tratamento;
use App\Models\Vocativo;
use Illuminate\Support\Facades\DB;
use App\Models\RessarcimentoOrgao;

class RessarcimentoOrgaoController extends Controller
{
    private $ressarcimento_orgao;

    public function __construct(RessarcimentoOrgao $ressarcimento_orgao)
    {
        $this->ressarcimento_orgao = $ressarcimento_orgao;
    }

    public function index()
    {
        $registros = DB::table('ressarcimento_orgaos')
            ->leftJoin('esferas', 'ressarcimento_orgaos.esfera_id', '=', 'esferas.id')
            ->leftJoin('poderes', 'ressarcimento_orgaos.poder_id', '=', 'poderes.id')
            ->leftJoin('tratamentos', 'ressarcimento_orgaos.tratamento_id', '=', 'tratamentos.id')
            ->leftJoin('vocativos', 'ressarcimento_orgaos.vocativo_id', '=', 'vocativos.id')
            ->leftJoin('funcoes', 'ressarcimento_orgaos.funcao_id', '=', 'funcoes.id')
            ->select(['ressarcimento_orgaos.*', 'esferas.name as esferaName', 'poderes.name as poderName', 'tratamentos.completo as tratamentoCompleto', 'vocativos.name as vocativoName', 'funcoes.name as funcaoName'])
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->ressarcimento_orgao->find($id);

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

    public function auxiliary()
    {
        try {
            $registros = array();

            //Esferas
            $registros['esferas'] = Esfera::all();

            //Poderes
            $registros['poderes'] = Poder::all();

            //Tratamentos
            $registros['tratamentos'] = Tratamento::all();

            //Vocativos
            $registros['vocativos'] = Vocativo::all();

            //Funcoes
            $registros['funcoes'] = Funcao::all();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(RessarcimentoOrgaoStoreRequest $request)
    {
        try {
            //Incluindo registro
            $registro = $this->ressarcimento_orgao->create($request->all());

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(RessarcimentoOrgaoUpdateRequest $request, $id)
    {
        try {
            $registro = $this->ressarcimento_orgao->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
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

    public function destroy($id)
    {
        try {
            $registro = $this->ressarcimento_orgao->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
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
        $registros = $this->ressarcimento_orgao
            ->leftJoin('esferas', 'ressarcimento_orgaos.esfera_id', '=', 'esferas.id')
            ->leftJoin('poderes', 'ressarcimento_orgaos.poder_id', '=', 'poderes.id')
            ->leftJoin('tratamentos', 'ressarcimento_orgaos.tratamento_id', '=', 'tratamentos.id')
            ->leftJoin('vocativos', 'ressarcimento_orgaos.vocativo_id', '=', 'vocativos.id')
            ->leftJoin('funcoes', 'ressarcimento_orgaos.funcao_id', '=', 'funcoes.id')
            ->select(['ressarcimento_orgaos.*', 'esferas.name as esferaName', 'poderes.name as poderName', 'tratamentos.completo as tratamentoCompleto', 'vocativos.name as vocativoName', 'funcoes.name as funcaoName'])
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

    public function quantidade_registros()
    {
        $registros = $this->ressarcimento_orgao->count();

        return $this->sendResponse('Quantidade enviada com sucesso.', 2000, null, $registros);
    }
}
