<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\SadMilitaresInformacao;

class SadMilitaresInformacaoObserver
{
    public function created(SadMilitaresInformacao $sad_militares_informacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'sad_militares_informacoes', $sad_militares_informacao, $sad_militares_informacao);
    }

    public function updated(SadMilitaresInformacao $sad_militares_informacao)
    {
        //gravar transacao
        $beforeData = $sad_militares_informacao->getOriginal();
        $laterData = $sad_militares_informacao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'sad_militares_informacoes', $beforeData, $laterData);
    }

    public function deleted(SadMilitaresInformacao $sad_militares_informacao)
    {
        //gravar transacao
        Transacoes::
        transacaoRecord(1, 3, 'sad_militares_informacoes', $sad_militares_informacao, $sad_militares_informacao);
    }
}
