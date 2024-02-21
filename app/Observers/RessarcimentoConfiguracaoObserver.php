<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\RessarcimentoConfiguracao;

class RessarcimentoConfiguracaoObserver
{
    public function created(RessarcimentoConfiguracao $ressarcimento_configuracao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'ressarcimento_configuracoes', $ressarcimento_configuracao, $ressarcimento_configuracao);
    }

    public function updated(RessarcimentoConfiguracao $ressarcimento_configuracao)
    {
        //gravar transacao
        $beforeData = $ressarcimento_configuracao->getOriginal();
        $laterData = $ressarcimento_configuracao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'ressarcimento_configuracoes', $beforeData, $laterData);
    }

    public function deleted(RessarcimentoConfiguracao $ressarcimento_configuracao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'ressarcimento_configuracoes', $ressarcimento_configuracao, $ressarcimento_configuracao);
    }
}
