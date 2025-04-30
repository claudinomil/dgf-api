<?php

use Illuminate\Support\Facades\Route;

//Auth
require __DIR__.'/routes_auth.php';

//Webservices
require __DIR__.'/routes_webservices.php';

//Submodulos
require __DIR__.'/routes_submodulos.php';

//Ferramentas
require __DIR__.'/routes_ferramentas.php';

//Notificacoes
require __DIR__.'/routes_notificacoes.php';

//Transacoes
require __DIR__.'/routes_transacoes.php';

//Grupos
require __DIR__.'/routes_grupos.php';

//Users
require __DIR__.'/routes_users.php';

//Operacoes
require __DIR__.'/routes_operacoes.php';

//Situacoes
require __DIR__.'/routes_situacoes.php';

//Dashboards
require __DIR__.'/routes_dashboards.php';

//Ressarcimento Referencias
require __DIR__.'/routes_ressarcimento_referencias.php';

//Ressarcimento Configurações
require __DIR__.'/routes_ressarcimento_configuracoes.php';

//Ressarcimento Orgaos
require __DIR__.'/routes_ressarcimento_orgaos.php';

//Ressarcimento Pagamentos
require __DIR__ . '/routes_ressarcimento_pagamentos.php';

//Ressarcimento Militares
require __DIR__ . '/routes_ressarcimento_militares.php';

//Ressarcimento Dashboard
require __DIR__ . '/routes_ressarcimento_cobrancas.php';

//Ressarcimento Recebimentos
require __DIR__ . '/routes_ressarcimento_recebimentos.php';

//Efetivo Militares
require __DIR__ . '/routes_efetivo_militares.php';

//Relatorios
require __DIR__ . '/routes_relatorios.php';

//Alimentação Tipos
require __DIR__.'/routes_alimentacao_tipos.php';

//Alimentação Planos
require __DIR__.'/routes_alimentacao_planos.php';

//Alimentação Unidades
require __DIR__.'/routes_alimentacao_unidades.php';

//Alimentação Remanejamentos
require __DIR__.'/routes_alimentacao_remanejamentos.php';

//Alimentação Quantitativos
require __DIR__.'/routes_alimentacao_quantitativos.php';

//Sad Militares Informações
require __DIR__.'/routes_sad_militares_informacoes.php';
