<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\RessarcimentoPagamento;
use App\Models\RessarcimentoOrgao;

class RessarcimentoPagamentoObserver
{
    public function created(RessarcimentoPagamento $ressarcimento_pagamento)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'ressarcimento_pagamentos', $ressarcimento_pagamento, $ressarcimento_pagamento);
    }

    public function updated(RessarcimentoPagamento $ressarcimento_pagamento)
    {
        //gravar transacao
        $beforeData = $ressarcimento_pagamento->getOriginal();
        $laterData = $ressarcimento_pagamento->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'ressarcimento_pagamentos', $beforeData, $laterData);
    }

    public function deleted(RessarcimentoPagamento $ressarcimento_pagamento)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'ressarcimento_pagamentos', $ressarcimento_pagamento, $ressarcimento_pagamento);
    }
}
