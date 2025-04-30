<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Ferramenta;

class FerramentaObserver
{
    public function created(Ferramenta $tool)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'ferramentas', $tool, $tool);
    }

    public function updated(Ferramenta $tool)
    {
        //gravar transacao
        $beforeData = $tool->getOriginal();
        $laterData = $tool->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'ferramentas', $beforeData, $laterData);
    }

    public function deleted(Ferramenta $tool)
    {
        //gravar transacao
        Transacoes::
        transacaoRecord(1, 3, 'ferramentas', $tool, $tool);
    }
}
