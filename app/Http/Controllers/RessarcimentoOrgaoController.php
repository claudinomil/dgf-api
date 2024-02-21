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

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, null, $registros), 200);
    }

    public function show($id)
    {
        try {
            $registro = $this->ressarcimento_orgao->find($id);

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

            return response()->json(ApiReturn::data('Registro enviado com sucesso.', 2000, null, $registros), 200);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiReturn::data($e->getMessage(), 5000, null, null), 500);
            }

            return response()->json(ApiReturn::data('Houve um erro ao realizar a operação.', 5000, null, null), 500);
        }
    }

    public function store(RessarcimentoOrgaoStoreRequest $request)
    {
        try {
            //Incluindo registro
            $registro = $this->ressarcimento_orgao->create($request->all());

            return response()->json(ApiReturn::data('Registro criado com sucesso.', 2010, null, null), 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiReturn::data($e->getMessage(), 5000, null, null), 500);
            }

            return response()->json(ApiReturn::data('Houve um erro ao realizar a operação.', 5000, null, null), 500);
        }
    }

    public function update(RessarcimentoOrgaoUpdateRequest $request, $id)
    {
        try {
            $registro = $this->ressarcimento_orgao->find($id);

            if (!$registro) {
                return response()->json(ApiReturn::data('Registro não encontrado.', 4040, null, null), 404);
            } else {
                //Alterando registro
                $registro->update($request->all());

                return response()->json(ApiReturn::data('Registro atualizado com sucesso.', 2000, null, $registro), 200);
            }
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
            $registro = $this->ressarcimento_orgao->find($id);

            if (!$registro) {
                return response()->json(ApiReturn::data('Registro não encontrado.', 4040, null, $registro), 404);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
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

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, null, $registros), 200);
    }

    public function quantidade_registros()
    {
        $registros = $this->ressarcimento_orgao->count();

        return response()->json(ApiReturn::data('Quantidade enviada com sucesso.', 2000, null, $registros), 200);
    }
}
