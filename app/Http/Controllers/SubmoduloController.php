<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Models\Submodulo;

class SubmoduloController extends Controller
{
    private $submodulo;

    public function __construct(Submodulo $submodulo)
    {
        $this->submodulo = $submodulo;
    }

    public function search($fieldSearch, $fieldValue, $fieldReturn)
    {
        $registros = $this->submodulo->where($fieldSearch, '=', $fieldValue)->get($fieldReturn);

        return $this->sendResponse('', 2000, '', $registros);
    }
}
