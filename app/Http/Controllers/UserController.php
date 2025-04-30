<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Agrupamento;
use App\Models\Ferramenta;
use App\Models\Grupo;
use App\Models\GrupoDashboard;
use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\LayoutMode;
use App\Models\LayoutStyle;
use App\Models\Modulo;
use App\Models\Notificacao;
use App\Models\NotificacaoLida;
use App\Models\Situacao;
use App\Models\Submodulo;
use App\Models\UserDashboardViews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $registros = $this->user->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->user->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, []);
            } else {
                //Verificar qtd de operações do usuário (para verificar se pode alterar alguns campos)
                $registro['user_operacoes_qtd'] = SuporteFacade::verificarRelacionamento('transacoes', 'user_id', $id);

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

            //Grupos
            $registros['grupos'] = Grupo::all();

            //Situações
            $registros['situacoes'] = Situacao::all();

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function store(UserStoreRequest $request)
    {
        try {
            //Campo avatar
            $request['avatar'] = 'build/assets/images/users/avatar-0.png';

            //grava uma senha provisoria (usuário tem que redefinir)
            $password = Str::password(10, true, true, false, false);
            $request['password'] = Hash::make($password);

            //Incluindo registro
            $this->user->create($request->all());

            //Enviar $password (Disfarçada) para Client enviar E-mail do Primeiro Acesso
            $password = 'G@998kLa2@-'.$password.'-_3ldfg3@yK';

            return $this->sendResponse('Registro criado com sucesso.', 2010, null, $password);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            $registro = $this->user->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Se Militar de referência for diferente
                if ($request['militar_rg'] != $registro['militar_rg']) {
                    //Tabela Transações
                    if (SuporteFacade::verificarRelacionamento('transacoes', 'user_id', $id) > 0) {
                        return $this->sendResponse('Náo é possível alterar o campo Referência Militar (RG). Usuário já realizou Transações no Sistema.', 2040, null, null);
                    }
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

    public function profileData($id)
    {
        try {
            $registro = array();

            //User
            $user = DB::table('users')
                ->leftJoin('grupos', 'grupos.id', '=', 'users.grupo_id')
                ->leftJoin('situacoes', 'situacoes.id', '=', 'users.situacao_id')
                ->select(['users.*', 'grupos.name as groupName', 'situacoes.name as situacaoName'])
                ->where('users.id', '=', $id)
                ->get();

            $registro['user'] = $user[0];

            //Transacoes Table
            $transacoes = DB::table('transacoes')
                ->leftJoin('submodulos', 'submodulos.id', '=', 'transacoes.submodulo_id')
                ->leftJoin('operacoes', 'operacoes.id', '=', 'transacoes.operacao_id')
                ->select(['transacoes.*', 'submodulos.name as submoduloName', 'operacoes.name as operacaoName'])
                ->where('transacoes.user_id', '=', $id)
                ->orderBy('transacoes.date', 'desc')
                ->limit(30)
                ->get();

            $registro['transacoesTable']['transacoes'] = $transacoes;

            //Transacoes Count
            $inclusions = DB::table('transacoes')->where('user_id', '=', $id)->where('operacao_id', '=', 1)->count();
            $alterations = DB::table('transacoes')->where('user_id', '=', $id)->where('operacao_id', '=', 2)->count();
            $exclusions = DB::table('transacoes')->where('user_id', '=', $id)->where('operacao_id', '=', 3)->count();

            $registro['transacoesCount']['inclusions'] = $inclusions;
            $registro['transacoesCount']['alterations'] = $alterations;
            $registro['transacoesCount']['exclusions'] = $exclusions;

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function updateAvatar(Request $request, $id)
    {
        try {
            $registro = $this->user->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                //Alterando registro
                $registro->update($request->all());

                return $this->sendResponse('Avatar atualizado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function editPassword(Request $request, $id)
    {
        try {
            $registro = $this->user->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                if (Hash::check($request['current_password'], $registro['password'])) {
                    //Alterando registro
                    $registro->update($request->all());

                    return $this->sendResponse('Senha atualizada com sucesso.', 2000, null, $registro);
                } else {
                    return $this->sendResponse('Senha Atual não confere.', 4040, null, null);
                }
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function editEmail(Request $request, $id)
    {
        try {
            $registro = $this->user->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                if ($request['current_email'] != $registro['new_email']) {
                    //Zerando campo para confirmação do E-mail do Usuário
                    $request['user_confirmed_at'] = NULL;

                    //Alterando registro
                    $registro->update($request->all());

                    return $this->sendResponse('E-mail atualizado com sucesso.', 2000, null, $registro);
                } else {
                    return $this->sendResponse('E-mail Atual não confere.', 4040, null, null);
                }
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function editmodestyle(Request $request, $id)
    {
        try {
            //Alterando registro
            User::where('id', $id)->update($request->all());

            return $this->sendResponse('Modo/Style atualizado com sucesso.', 2000, null, null);
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
            $registro = $this->user->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela users_dashboards_views
                if (SuporteFacade::verificarRelacionamento('users_dashboards_views', 'user_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado em Usuários Dashboards.', 2040, null, null);
                }

                //Tabela Transações
                if (SuporteFacade::verificarRelacionamento('transacoes', 'user_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado em Transações.', 2040, null, null);
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
        $registros = $this->user
            ->select(['users.*'])
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

    public function userPermissoesSettings($searchSubmodulo)
    {
        try {
            if (!Auth::check()) {
                return $this->sendResponse('Usuário não está logado.', 4040, null, null);
            } else {
                //Cria array
                $registros = array();

                //Dados Usuário Logado
                $registros['userData'] = Auth::user();

                $registros['userPermissoes'] = GrupoPermissao
                    ::join('grupos', 'grupos_permissoes.grupo_id', '=', 'grupos.id')
                    ->join('permissoes', 'grupos_permissoes.permissao_id', '=', 'permissoes.id')
                    ->select('permissoes.name as permissao')
                    ->where('grupos_permissoes.grupo_id', Auth::user()->grupo_id)
                    ->get();

                //Menu Módulos
                //$registros['menuModulos'] = Modulo::where('ordem_visualizacao', '>', '0')->orderBy('ordem_visualizacao', 'asc')->orderBy('name', 'asc')->get();
                $registros['menuModulos'] = Modulo
                    ::leftjoin('setores', 'setores.id', 'modulos.setor_id')
                    ->select('modulos.*', 'setores.name as setor_name', 'setores.menu_icon as setor_menu_icon')
                    ->where('modulos.ordem_visualizacao', '>', '0')
                    ->orderBy('setores.ordem_visualizacao', 'asc')
                    ->orderBy('modulos.ordem_visualizacao', 'asc')
                    ->orderBy('modulos.name', 'asc')
                    ->get();

                //Menu Submódulos
                $registros['menuSubmodulos'] = Submodulo
                    ::select('submodulos.*')
                    ->where('ordem_visualizacao', '>', '0')
                    ->orderBy('ordem_visualizacao', 'asc')
                    ->orderBy('name', 'asc')
                    ->get();

                //Layouts Modes
                $registros['layouts_modes'] = LayoutMode::all();

                //Layouts Styles
                $registros['layouts_styles'] = LayoutStyle::all();

                //Ferramentas
                $registros['ferramentas'] = Ferramenta
                    ::join('users', 'ferramentas.user_id', '=', 'users.id')
                    ->select(['ferramentas.*', 'users.name as userName'])
                    ->where('ferramentas.user_id', Auth::user()->id)
                    ->orderBy('name', 'asc')
                    ->get();

                //Notificações não lidas pelo Usuário Logado''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Buscar ids das notificações lidas pelo Usuário
                $notIn = NotificacaoLida
                    ::leftJoin('notificacoes', 'notificacoes.id', '=', 'notificacoes_lidas.notificacao_id')
                    ->select('notificacoes_lidas.notificacao_id')
                    ->where('notificacoes_lidas.user_id', '=', Auth::user()->id)
                    ->get();

                $notificacoesNotIn = array();
                foreach ($notIn as $item) {
                    $notificacoesNotIn[] = $item->notificacao_id;
                }

                //Buscando Notificações não lidas
                $registros['notificacoes'] = Notificacao
                    ::leftJoin('users', 'users.id', '=', 'notificacoes.user_id')
                    ->leftJoin('notificacoes_lidas', 'notificacoes_lidas.notificacao_id', '=', 'notificacoes.id')
                    ->select(['notificacoes.*', 'users.name as userName', 'users.avatar as userAvatar'])
                    ->whereNotIn('notificacoes.id', $notificacoesNotIn)
                    ->orderBy('notificacoes.date', 'desc')
                    ->orderBy('notificacoes.time', 'desc')
                    ->orderBy('notificacoes.title', 'asc')
                    ->limit(10)
                    ->get();
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Dados para o CRUD ajax''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Submódulo variavel Permissão
                $registros['prefixPermissaoSubmodulo'] = Submodulo::select('prefix_permissao')->where('menu_route', '=', $searchSubmodulo)->get();

                //Submódulo variavel Nome
                $registros['nameSubmodulo'] = Submodulo::select('name')->where('menu_route', '=', $searchSubmodulo)->get();

                //Submódulo nome dos campos
                $registros['namesFieldsSubmodulo'] = Schema::getColumnListing($searchSubmodulo);
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function userWelcomePermissao()
    {
        try {
            if (!Auth::check()) {
                return $this->sendResponse('Usuário não está logado.', 4040, null, null);
            } else {

                //Cria array
                $registros = array();

                //Dados Usuário Logado
                $registros['userData'] = Auth::user();

                //Agrupamentos
                $registros['agrupamentos'] = Agrupamento::orderby('ordem_visualizacao', 'ASC')->get();

                return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function userLoggedData()
    {
        try {
            if (!Auth::check()) {
                return $this->sendResponse('Usuário não está logado.', 4040, null, null);
            } else {
                //Cria array
                $registro = array();

                //Dados Usuário Logado
                $registro['userData'] = Auth::user();

                return $this->sendResponse('Registro enviada com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            //Removendo Token
            $user = Auth::user()->token();
            $user->revoke();

            return $this->sendResponse('Logout realizado com sucesso e o token foi excluído.', 4001, null, null);

        }

        return $this->sendResponse('Logout não realizado.', 5000, null, null);
    }

    public function exist($email)
    {
        $registro = $this->user->where('email', '=', $email)->count();

        return $this->sendResponse('Exist enviado com sucesso.', 2000, '', $registro);
    }

    public function confirm($email)
    {
        $registro = $this->user->where('email', '=', $email)->get();

        if (count($registro) == 1) {
            if ($registro[0]['user_confirmed_at'] != '') {
                //Usuário sem Grupo
                if ($registro[0]['grupo_id'] == null) {
                    return $this->sendResponse('Usuário sem Grupo de Acesso.', 2002, null, null);
                }

                //Usuário sem Situação
                if ($registro[0]['situacao_id'] == null) {
                    return $this->sendResponse('Usuário sem Situação.', 2002, null, null);
                }

                //Usuário Bloqueado
                if ($registro[0]['situacao_id'] == 2) {
                    return $this->sendResponse('Usuário Bloqueado.', 2002, null, null);
                }

                //Usuário sem Layout Mode
                if ($registro[0]['layout_mode'] == null) {
                    return $this->sendResponse('Usuário sem Layout Mode.', 2002, null, null);
                }

                //Usuário sem Layout Style
                if ($registro[0]['layout_style'] == null) {
                    return $this->sendResponse('Usuário sem Layout Style.', 2002, null, null);
                }

                //Usuário confirmado
                return $this->sendResponse('Usuário confirmado.', 2000, null, $registro);
            } else {
                return $this->sendResponse('Usuário não confirmado.', 2004, null, null);
            }
        } else {
            return $this->sendResponse('Usuário não existe.', 2005, null, null);
        }
    }

    public function update_confirm(Request $request)
    {
        try {
            //Alterar tabela users
            $user = User::where('email', $request->email)->update(['user_confirmed_at' => date('Y-m-d H:i:s')]);

            if (!$user) {
                return $this->sendResponse('Operação não concluída.', 4040, null, null);
            }

            return $this->sendResponse('Operações realizadas com sucesso.', 2000, null, null);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
}
