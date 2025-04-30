<?php

namespace App\Providers;

use App\Models\AlimentacaoPlano;
use App\Models\AlimentacaoQuantitativo;
use App\Models\AlimentacaoRemanejamento;
use App\Models\AlimentacaoTipo;
use App\Models\AlimentacaoUnidade;
use App\Models\Grupo;
use App\Models\RessarcimentoCobranca;
use App\Models\RessarcimentoConfiguracao;
use App\Models\RessarcimentoPagamento;
use App\Models\Notificacao;
use App\Models\Operacao;
use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoOrgao;
use App\Models\RessarcimentoRecebimento;
use App\Models\RessarcimentoReferencia;
use App\Models\SadMilitaresInformacao;
use App\Models\Situacao;
use App\Models\Ferramenta;
use App\Models\User;
use App\Observers\AlimentacaoPlanoObserver;
use App\Observers\AlimentacaoQuantitativoObserver;
use App\Observers\AlimentacaoRemanejamentoObserver;
use App\Observers\AlimentacaoTipoObserver;
use App\Observers\AlimentacaoUnidadeObserver;
use App\Observers\GrupoObserver;
use App\Observers\RessarcimentoCobrancaObserver;
use App\Observers\RessarcimentoConfiguracaoObserver;
use App\Observers\RessarcimentoPagamentoObserver;
use App\Observers\NotificacaoObserver;
use App\Observers\OperacaoObserver;
use App\Observers\RessarcimentoMilitarObserver;
use App\Observers\RessarcimentoOrgaoObserver;
use App\Observers\RessarcimentoRecebimentoObserver;
use App\Observers\RessarcimentoReferenciaObserver;
use App\Observers\SadMilitaresInformacaoObserver;
use App\Observers\SituacaoObserver;
use App\Observers\FerramentaObserver;
use App\Observers\UserObserver;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void
    {
        Ferramenta::observe(FerramentaObserver::class);
        Grupo::observe(GrupoObserver::class);
        Notificacao::observe(NotificacaoObserver::class);
        Operacao::observe(OperacaoObserver::class);
        Situacao::observe(SituacaoObserver::class);
        User::observe(UserObserver::class);
        AlimentacaoTipo::observe(AlimentacaoTipoObserver::class);
        AlimentacaoPlano::observe(AlimentacaoPlanoObserver::class);
        AlimentacaoUnidade::observe(AlimentacaoUnidadeObserver::class);
        AlimentacaoRemanejamento::observe(AlimentacaoRemanejamentoObserver::class);
        AlimentacaoQuantitativo::observe(AlimentacaoQuantitativoObserver::class);
        RessarcimentoCobranca::observe(RessarcimentoCobrancaObserver::class);
        RessarcimentoConfiguracao::observe(RessarcimentoConfiguracaoObserver::class);
        RessarcimentoPagamento::observe(RessarcimentoPagamentoObserver::class);
        RessarcimentoMilitar::observe(RessarcimentoMilitarObserver::class);
        RessarcimentoOrgao::observe(RessarcimentoOrgaoObserver::class);
        RessarcimentoReferencia::observe(RessarcimentoReferenciaObserver::class);
        RessarcimentoRecebimento::observe(RessarcimentoRecebimentoObserver::class);
        SadMilitaresInformacao::observe(SadMilitaresInformacaoObserver::class);
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
