<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Situacao;

class SituacaoObserver
{
    public function created(Situacao $situacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'situacoes', $situacao, $situacao);
    }

    public function updated(Situacao $situacao)
    {
        //gravar transacao
        $beforeData = $situacao->getOriginal();
        $laterData = $situacao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'situacoes', $beforeData, $laterData);
    }

    public function deleted(Situacao $situacao)
    {
        //gravar transacao
        Transacoes::
        transacaoRecord(1, 3, 'situacoes', $situacao, $situacao);
    }
}
