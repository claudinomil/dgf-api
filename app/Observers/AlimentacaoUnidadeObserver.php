<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\AlimentacaoUnidade;

class AlimentacaoUnidadeObserver
{
    public function created(AlimentacaoUnidade $alimentacao_unidade)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'alimentacao_unidades', $alimentacao_unidade, $alimentacao_unidade);
    }

    public function updated(AlimentacaoUnidade $alimentacao_unidade)
    {
        //gravar transacao
        $beforeData = $alimentacao_unidade->getOriginal();
        $laterData = $alimentacao_unidade->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'alimentacao_unidades', $beforeData, $laterData);
    }

    public function deleted(AlimentacaoUnidade $alimentacao_unidade)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'alimentacao_unidades', $alimentacao_unidade, $alimentacao_unidade);
    }
}
