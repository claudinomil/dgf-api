<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\AlimentacaoPlano;

class AlimentacaoPlanoObserver
{
    public function created(AlimentacaoPlano $alimentacao_plano)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'alimentacao_planos', $alimentacao_plano, $alimentacao_plano);
    }

    public function updated(AlimentacaoPlano $alimentacao_plano)
    {
        //gravar transacao
        $beforeData = $alimentacao_plano->getOriginal();
        $laterData = $alimentacao_plano->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'alimentacao_planos', $beforeData, $laterData);
    }

    public function deleted(AlimentacaoPlano $alimentacao_plano)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'alimentacao_planos', $alimentacao_plano, $alimentacao_plano);
    }
}
