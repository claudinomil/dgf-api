<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Grupo;

class GrupoObserver
{
    public function created(Grupo $grupo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'grupos', $grupo, $grupo);
    }

    public function updated(Grupo $grupo)
    {
        //gravar transacao
        $beforeData = $grupo->getOriginal();
        $laterData = $grupo->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'grupos', $beforeData, $laterData);
    }

    public function deleted(Grupo $grupo)
    {
        //gravar transacao
        Transacoes::
        transacaoRecord(1, 3, 'grupos', $grupo, $grupo);
    }
}
