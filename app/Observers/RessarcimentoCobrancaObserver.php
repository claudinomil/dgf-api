<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\RessarcimentoCobranca;

class RessarcimentoCobrancaObserver
{
    public function created(RessarcimentoCobranca $ressarcimento_cobranca)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'ressarcimento_cobrancas', $ressarcimento_cobranca, $ressarcimento_cobranca);
    }

    public function updated(RessarcimentoCobranca $ressarcimento_cobranca)
    {
        //gravar transacao
        $beforeData = $ressarcimento_cobranca->getOriginal();
        $laterData = $ressarcimento_cobranca->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'ressarcimento_cobrancas', $beforeData, $laterData);
    }

    public function deleted(RessarcimentoCobranca $ressarcimento_cobranca)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'ressarcimento_cobrancas', $ressarcimento_cobranca, $ressarcimento_cobranca);
    }
}
