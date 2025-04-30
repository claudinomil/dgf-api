<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;

class WebserviceController extends Controller
{
    public function militar($field, $value)
    {
        try {
            //WebService - DGF
            $parametros = array();
            $parametros['evento'] = 1;
            $parametros['field'] = $field;
            $parametros['value'] = $value;

            $registro = SuporteFacade::webserviceDgf($parametros);

            //Registro recebido com sucesso
            if (isset($registro['success'])) {
                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro['success'][0]);
            } else {
                return $this->sendResponse('Erro.', 2040, null, $registro['error']);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
}
