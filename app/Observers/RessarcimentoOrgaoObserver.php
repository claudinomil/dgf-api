<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\RessarcimentoOrgao;

class RessarcimentoOrgaoObserver
{
    public function created(RessarcimentoOrgao $ressarcimento_orgao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'ressarcimento_orgaos', $ressarcimento_orgao, $ressarcimento_orgao);
    }

    public function updated(RessarcimentoOrgao $ressarcimento_orgao)
    {
        //gravar transacao
        $beforeData = $ressarcimento_orgao->getOriginal();
        $laterData = $ressarcimento_orgao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'ressarcimento_orgaos', $beforeData, $laterData);
    }

    public function deleted(RessarcimentoOrgao $ressarcimento_orgao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'ressarcimento_orgaos', $ressarcimento_orgao, $ressarcimento_orgao);
    }
}
