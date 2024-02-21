<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\RessarcimentoReferencia;

class RessarcimentoReferenciaObserver
{
    public function created(RessarcimentoReferencia $ressarcimento_referencia)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'ressarcimento_referencias', $ressarcimento_referencia, $ressarcimento_referencia);
    }

    public function updated(RessarcimentoReferencia $ressarcimento_referencia)
    {
        //gravar transacao
        $beforeData = $ressarcimento_referencia->getOriginal();
        $laterData = $ressarcimento_referencia->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'ressarcimento_referencias', $beforeData, $laterData);
    }

    public function deleted(RessarcimentoReferencia $ressarcimento_referencia)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'ressarcimento_referencias', $ressarcimento_referencia, $ressarcimento_referencia);
    }
}
