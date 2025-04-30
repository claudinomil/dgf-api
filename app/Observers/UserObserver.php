<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'users', $user, $user);
    }

    public function updated(User $user)
    {
        //gravar transacao
        $beforeData = $user->getOriginal();
        $laterData = $user->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'users', $beforeData, $laterData);
    }

    public function deleted(User $user)
    {
        //gravar transacao
        Transacoes::
        transacaoRecord(1, 3, 'users', $user, $user);
    }
}
