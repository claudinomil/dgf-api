<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Http\Requests\NotificacaoStoreRequest;
use App\Http\Requests\NotificacaoUpdateRequest;
use App\Models\NotificacaoRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Notificacao;

class NotificacaoController extends Controller
{
    private $notificacao;

    public function __construct(Notificacao $notificacao)
    {
        $this->notificacao = $notificacao;
    }

    public function index()
    {
        $registros = $this->notificacao->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function show($id)
    {
        try {
            $registro = DB::table('notificacoes')
                ->join('users', 'notificacoes.user_id', '=', 'users.id')
                ->select(['notificacoes.*', 'users.name as userName'])
                ->where('notificacoes.id', $id)
                ->get();

            //Retornar o array no padrao (simples)
            $registro = $registro[0];

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, []);
            } else {
                //Verificar se Usuário Logado já leu a Notificação
                if (DB::table('notificacoes_lidas')
                    ->where('notificacao_id', $id)
                    ->where('user_id', Auth::user()->id)
                    ->doesntExist()) {

                    //Se não leu, marcar Notificação como lida
                    DB::table('notificacoes_lidas')->insert([
                        'notificacao_id' => $id,
                        'user_id' => Auth::user()->id,
                        'date' => date('Y-m-d'),
                        'time' => date('H:i:s')
                    ]);
                }

                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(NotificacaoStoreRequest $request)
    {
        try {
            //Incluindo registro
            $this->notificacao->create($request->all());

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(NotificacaoUpdateRequest $request, $id)
    {
        try {
            $registro = $this->notificacao->find($id);

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
            $registro = $this->notificacao->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Tabela notificacoes_lidas
                if (SuporteFacade::verificarRelacionamento('notificacoes_lidas', 'notificacao_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Notificações não Lidas.', 2040, null, null);
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
        $registros = $this->notificacao
            ->select(['notificacoes.*'])
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

    public function unreadNotificacoes($id)
    {
        //Buscar ids das notificações lidas pelo Usuário
        $notIn = DB::table('notificacoes_lidas')->select('notificacao_id')->where('user_id', '=', $id)->get();

        $notificacoesNotIn = array();
        foreach ($notIn as $item) {
            $notificacoesNotIn[] = $item->notificacao_id;
        }

        //Buscando Notificações não lidas
        $registros = DB::table('notificacoes')
            ->leftJoin('users', 'users.id', '=', 'notificacoes.user_id')
            ->leftJoin('notificacoes_lidas', 'notificacoes_lidas.notificacao_id', '=', 'notificacoes.id')
            ->select(['notificacoes.*', 'users.name as userName', 'users.avatar as userAvatar'])
            ->whereNotIn('notificacoes.id', $notificacoesNotIn)
            ->orderBy('notificacoes.date', 'desc')
            ->orderBy('notificacoes.time', 'desc')
            ->orderBy('notificacoes.title', 'asc')
            ->limit(10)
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }
}
