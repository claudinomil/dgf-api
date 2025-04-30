<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\AlimentacaoQuantitativo;

class AlimentacaoQuantitativoObserver
{
    public function created(AlimentacaoQuantitativo $alimentacao_quantitativo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'alimentacao_quantitativos', $alimentacao_quantitativo, $alimentacao_quantitativo);
    }

    public function updated(AlimentacaoQuantitativo $alimentacao_quantitativo)
    {
        //gravar transacao
        $beforeData = $alimentacao_quantitativo->getOriginal();
        $laterData = $alimentacao_quantitativo->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'alimentacao_quantitativos', $beforeData, $laterData);
    }

    public function deleted(AlimentacaoQuantitativo $alimentacao_quantitativo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'alimentacao_quantitativos', $alimentacao_quantitativo, $alimentacao_quantitativo);
    }
}
