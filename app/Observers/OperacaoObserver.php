<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Operacao;

class OperacaoObserver
{
    public function created(Operacao $operacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'operacoes', $operacao, $operacao);
    }

    public function updated(Operacao $operacao)
    {
        //gravar transacao
        $beforeData = $operacao->getOriginal();
        $laterData = $operacao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'operacoes', $beforeData, $laterData);
    }

    public function deleted(Operacao $operacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'operacoes', $operacao, $operacao);
    }
}
