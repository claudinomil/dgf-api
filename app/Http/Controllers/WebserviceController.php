<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;

class WebserviceController extends Controller
{
    public function militar($field, $value)
    {
        try {
            //WebService SAC - DGF
            $registro = SuporteFacade::webserviceSacDgf(1, $field, $value);

            //Registro recebido com sucesso
            if (isset($registro['success'])) {
                return response()->json(ApiReturn::data('Registro enviado com sucesso.', 2000, null, $registro['success'][0]), 200);
            } else {
                return response()->json(ApiReturn::data('Erro.', 2040, null, $registro['error']), 200);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiReturn::data($e->getMessage(), 5000, null, null), 500);
            }

            return response()->json(ApiReturn::data('Houve um erro ao realizar a operação.', 5000, null, null), 500);
        }
    }
}
