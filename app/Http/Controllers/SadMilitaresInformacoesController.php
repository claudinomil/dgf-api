<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Http\Requests\SadMilitaresInformacaoStoreRequest;
use App\Http\Requests\SadMilitaresInformacaoUpdateRequest;
use App\Models\Funcao;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\SadMilitaresInformacao;
use Illuminate\Support\Str;

class SadMilitaresInformacoesController extends Controller
{
    private $sad_militares_informacao;

    public function __construct(SadMilitaresInformacao $sad_militares_informacao)
    {
        $this->sad_militares_informacao = $sad_militares_informacao;
    }

    public function index()
    {
        $registros = $this->sad_militares_informacao->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->sad_militares_informacao->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, []);
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

            //Setores
            $registros['setores'] = Setor::all();

            //Funções
            $registros['funcoes'] = Funcao::all();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(SadMilitaresInformacaoStoreRequest $request)
    {
        try {
            //Campo foto
            $request['foto'] = 'build/assets/images/sad_militares_informacoes/foto-0.png';

            //Incluindo registro
            $this->sad_militares_informacao->create($request->all());

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(SadMilitaresInformacaoUpdateRequest $request, $id)
    {
        try {
            $registro = $this->sad_militares_informacao->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
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

    public function profileData($id)
    {
        try {
            $registro = array();

            //SadMilitaresInformacao
            $sad_militares_informacao = DB::table('sad_militares_informacoes')
                ->Join('setores', 'setores.id', '=', 'sad_militares_informacoes.setor_id')
                ->leftJoin('funcoes', 'funcoes.id', '=', 'sad_militares_informacoes.funcao_id')
                ->select(['sad_militares_informacoes.*', 'setores.name as setorName', 'funcoes.name as funcaoName'])
                ->where('sad_militares_informacoes.id', '=', $id)
                ->get();

            $registro['sad_militares_informacao'] = $sad_militares_informacao[0];

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function updateFoto(Request $request, $id)
    {
        try {
            $registro = $this->sad_militares_informacao->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                return $this->sendResponse('Foto atualizada com sucesso.', 2000, null, $registro);
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
            $registro = $this->sad_militares_informacao->find($id);

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
        $registros = $this->sad_militares_informacao
            ->select(['sad_militares_informacoes.*'])
            ->where(function ($query) use ($filtros) {
                //Variavel para controle
                $qtdFiltros = count($filtros) / 4;
                $indexCampo = 0;

                for ($i = 1; $i <= $qtdFiltros; $i++) {
                    //Valores do Filtro
                    $condicao = $filtros[$indexCampo];
                    $campo = $filtros[$indexCampo + 1];
                    $operacao = $filtros[$indexCampo + 2];
                    $dado = $filtros[$indexCampo + 3];

                    //Operações
                    if ($operacao == 1) {
                        if ($condicao == 1) {
                            $query->where($campo, 'like', '%' . $dado . '%');
                        } else {
                            $query->orwhere($campo, 'like', '%' . $dado . '%');
                        }
                    }
                    if ($operacao == 2) {
                        if ($condicao == 1) {
                            $query->where($campo, '=', $dado);
                        } else {
                            $query->orwhere($campo, '=', $dado);
                        }
                    }
                    if ($operacao == 3) {
                        if ($condicao == 1) {
                            $query->where($campo, '>', $dado);
                        } else {
                            $query->orwhere($campo, '>', $dado);
                        }
                    }
                    if ($operacao == 4) {
                        if ($condicao == 1) {
                            $query->where($campo, '>=', $dado);
                        } else {
                            $query->orwhere($campo, '>=', $dado);
                        }
                    }
                    if ($operacao == 5) {
                        if ($condicao == 1) {
                            $query->where($campo, '<', $dado);
                        } else {
                            $query->orwhere($campo, '<', $dado);
                        }
                    }
                    if ($operacao == 6) {
                        if ($condicao == 1) {
                            $query->where($campo, '<=', $dado);
                        } else {
                            $query->orwhere($campo, '<=', $dado);
                        }
                    }
                    if ($operacao == 7) {
                        if ($condicao == 1) {
                            $query->where($campo, 'like', $dado . '%');
                        } else {
                            $query->orwhere($campo, 'like', $dado . '%');
                        }
                    }
                    if ($operacao == 8) {
                        if ($condicao == 1) {
                            $query->where($campo, 'like', '%' . $dado);
                        } else {
                            $query->orwhere($campo, 'like', '%' . $dado);
                        }
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
}
