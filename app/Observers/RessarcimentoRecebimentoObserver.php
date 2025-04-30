<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\RessarcimentoRecebimento;

class RessarcimentoRecebimentoObserver
{
    public function updated(RessarcimentoRecebimento $tool)
    {
        //gravar transacao
        $beforeData = $tool->getOriginal();
        $laterData = $tool->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'ressarcimento_recebimentos', $beforeData, $laterData);
    }
}
