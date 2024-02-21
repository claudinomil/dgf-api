<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\RessarcimentoMilitar;

class RessarcimentoMilitarObserver
{
    public function created(RessarcimentoMilitar $ressarcimento_militar)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'ressarcimento_militares', $ressarcimento_militar, $ressarcimento_militar);
    }

    public function updated(RessarcimentoMilitar $ressarcimento_militar)
    {
        //gravar transacao
        $beforeData = $ressarcimento_militar->getOriginal();
        $laterData = $ressarcimento_militar->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'ressarcimento_militares', $beforeData, $laterData);
    }

    public function deleted(RessarcimentoMilitar $ressarcimento_militar)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'ressarcimento_militares', $ressarcimento_militar, $ressarcimento_militar);
    }
}
