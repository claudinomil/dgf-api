<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\AlimentacaoRemanejamento;

class AlimentacaoRemanejamentoObserver
{
    public function created(AlimentacaoRemanejamento $alimentacao_remanejamento)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'alimentacao_remanejamentos', $alimentacao_remanejamento, $alimentacao_remanejamento);
    }

    public function updated(AlimentacaoRemanejamento $alimentacao_remanejamento)
    {
        //gravar transacao
        $beforeData = $alimentacao_remanejamento->getOriginal();
        $laterData = $alimentacao_remanejamento->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'alimentacao_remanejamentos', $beforeData, $laterData);
    }

    public function deleted(AlimentacaoRemanejamento $alimentacao_remanejamento)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'alimentacao_remanejamentos', $alimentacao_remanejamento, $alimentacao_remanejamento);
    }
}
