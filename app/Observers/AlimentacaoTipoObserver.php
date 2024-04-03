<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\AlimentacaoTipo;

class AlimentacaoTipoObserver
{
    public function created(AlimentacaoTipo $alimentacao_tipo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'alimentacao_tipos', $alimentacao_tipo, $alimentacao_tipo);
    }

    public function updated(AlimentacaoTipo $alimentacao_tipo)
    {
        //gravar transacao
        $beforeData = $alimentacao_tipo->getOriginal();
        $laterData = $alimentacao_tipo->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'alimentacao_tipos', $beforeData, $laterData);
    }

    public function deleted(AlimentacaoTipo $alimentacao_tipo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'alimentacao_tipos', $alimentacao_tipo, $alimentacao_tipo);
    }
}
