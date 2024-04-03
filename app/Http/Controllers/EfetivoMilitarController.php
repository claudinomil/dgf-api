<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Models\User;

class EfetivoMilitarController extends Controller
{
    public function index()
    {
        //WebService - DGF
        $parametros = array();
        $parametros['evento'] = 2;

        $registros = SuporteFacade::webserviceDgf($parametros);
        $registros = $registros['success'];

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, null, $registros), 200);
    }

    public function show($id)
    {
        try {
            //WebService - DGF
            $parametros = array();
            $parametros['evento'] = 1;
            $parametros['field'] = 'efetivo_id';
            $parametros['value'] = $id;

            $registro = SuporteFacade::webserviceDgf($parametros);
            $registro = $registro['success'][0];

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

    public function filter($array_dados)
    {
        //Variavel para controle
        $filtros = explode(',', $array_dados);
        $qtdFiltros = count($filtros) / 4;
        $indexCampo = 0;
        $selectWhere = 'WHERE 1=1 ';

        for($i=1; $i<=$qtdFiltros; $i++) {
            //Valores do Filtro
            $condicao = $filtros[$indexCampo];
            $campo = $filtros[$indexCampo+1];
            $operacao = $filtros[$indexCampo+2];
            $dado = $filtros[$indexCampo+3];

            //Formatando $dado se campo = dbu_efetivo.rg
            if ($campo == 'dbu_efetivo.rg') {
                //Operação
                //$operacao=1 : Contém
                //$operacao=2 : Igual
                //$operacao=3 : Maior que
                //$operacao=4 : Maior ou igual a
                //$operacao=5 : Menor que
                //$operacao=6 : Menor ou igual a
                //$operacao=7 : No início
                //$operacao=8 : No fim

                if ($operacao == 1) {
                    $dado = SuporteFacade::getRG(0, $dado);
                    $dado = SuporteFacade::getRG(4, $dado);
                } else if ($operacao == 2 || $operacao == 3 || $operacao == 4 || $operacao == 5 || $operacao == 6) {
                    $dado = SuporteFacade::getRG(0, $dado);
                    $dado = SuporteFacade::getRG(2, $dado);
                }
            }

            //Operações
            if ($operacao == 1) {
                if ($condicao == 1) {$selectWhere .= "AND ".$campo." like '%".$dado."%' ";} else {$selectWhere .= "OR ".$campo." like '%".$dado."%' ";}
            }
            if ($operacao == 2) {
                if ($condicao == 1) {$selectWhere .= "AND ".$campo."='".$dado."' ";} else {$selectWhere .= "OR ".$campo."='".$dado."' ";}
            }
            if ($operacao == 3) {
                if ($condicao == 1) {$selectWhere .= "AND ".$campo.">'".$dado."' ";} else {$selectWhere .= "OR ".$campo.">'".$dado."' ";}
            }
            if ($operacao == 4) {
                if ($condicao == 1) {$selectWhere .= "AND ".$campo.">='".$dado."' ";} else {$selectWhere .= "OR ".$campo.">='".$dado."' ";}
            }
            if ($operacao == 5) {
                if ($condicao == 1) {$selectWhere .= "AND ".$campo."<'".$dado."' ";} else {$selectWhere .= "OR ".$campo."<'".$dado."' ";}
            }
            if ($operacao == 6) {
                if ($condicao == 1) {$selectWhere .= "AND ".$campo."<='".$dado."' ";} else {$selectWhere .= "OR ".$campo."<='".$dado."' ";}
            }
            if ($operacao == 7) {
                if ($condicao == 1) {$selectWhere .= "AND ".$campo." like '".$dado."%' ";} else {$selectWhere .= "OR ".$campo." like '".$dado."%' ";}
            }
            if ($operacao == 8) {
                if ($condicao == 1) {$selectWhere .= "AND ".$campo." like '%".$dado."' ";} else {$selectWhere .= "OR ".$campo." like '%".$dado."' ";}
            }

            //Atualizar indexCampo
            $indexCampo = $indexCampo + 4;
        }

        //return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, null, $selectWhere), 200);

        //WebService - DGF
        $parametros = array();
        $parametros['evento'] = 2;
        $parametros['selectWhere'] = $selectWhere;

        $registros = SuporteFacade::webserviceDgf($parametros);
        $registros = $registros['success'];



//        //Filtros enviados pelo Client
//        $filtros = explode(',', $array_dados);
//
//        //Registros
//        $registros = $this->efetivo_militar
//            ->select(['efetivo_militares.*'])
//            ->where(function($query) use($filtros) {
//                //Variavel para controle
//                $qtdFiltros = count($filtros) / 4;
//                $indexCampo = 0;
//
//                for($i=1; $i<=$qtdFiltros; $i++) {
//                    //Valores do Filtro
//                    $condicao = $filtros[$indexCampo];
//                    $campo = $filtros[$indexCampo+1];
//                    $operacao = $filtros[$indexCampo+2];
//                    $dado = $filtros[$indexCampo+3];
//
//                    //Operações
//                    if ($operacao == 1) {
//                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado.'%');} else {$query->orwhere($campo, 'like', '%'.$dado.'%');}
//                    }
//                    if ($operacao == 2) {
//                        if ($condicao == 1) {$query->where($campo, '=', $dado);} else {$query->orwhere($campo, '=', $dado);}
//                    }
//                    if ($operacao == 3) {
//                        if ($condicao == 1) {$query->where($campo, '>', $dado);} else {$query->orwhere($campo, '>', $dado);}
//                    }
//                    if ($operacao == 4) {
//                        if ($condicao == 1) {$query->where($campo, '>=', $dado);} else {$query->orwhere($campo, '>=', $dado);}
//                    }
//                    if ($operacao == 5) {
//                        if ($condicao == 1) {$query->where($campo, '<', $dado);} else {$query->orwhere($campo, '<', $dado);}
//                    }
//                    if ($operacao == 6) {
//                        if ($condicao == 1) {$query->where($campo, '<=', $dado);} else {$query->orwhere($campo, '<=', $dado);}
//                    }
//                    if ($operacao == 7) {
//                        if ($condicao == 1) {$query->where($campo, 'like', $dado.'%');} else {$query->orwhere($campo, 'like', $dado.'%');}
//                    }
//                    if ($operacao == 8) {
//                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado);} else {$query->orwhere($campo, 'like', '%'.$dado);}
//                    }
//
//                    //Atualizar indexCampo
//                    $indexCampo = $indexCampo + 4;
//                }
//            }
//            )->get();
//
//        //Código SQL Bruto
//        //$sql = DB::getQueryLog();

        return response()->json(ApiReturn::data('Lista de dados enviada com sucesso.', 2000, null, $registros), 200);
    }
}
