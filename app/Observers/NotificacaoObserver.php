<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Notificacao;

class NotificacaoObserver
{
    public function created(Notificacao $notificacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'notificacoes', $notificacao, $notificacao);
    }

    public function updated(Notificacao $notificacao)
    {
        //gravar transacao
        $beforeData = $notificacao->getOriginal();
        $laterData = $notificacao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'notificacoes', $beforeData, $laterData);
    }

    public function deleted(Notificacao $notificacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'notificacoes', $notificacao, $notificacao);
    }
}
