<?php

Route::prefix('rotas_testes')->group(function () {
    Route::get('/formata_valores/{op}/{valor}', function ($op, $valor) {
        //Vazio
        if ($valor == '') {
            $valor = 0;
        }

        //Retirando espaços
        $valor = trim($valor);
        $valor = str_replace(" ", "", $valor);

        //Montando um array com cada digito
        $dados = str_split($valor);

        //Guardar ultima posição de um ponto/virgula
        $ponto_virgula = 0;

        //Posição da casa decimal
        $posicao_casa_decimal = 0;

        //posição
        $posicao = 0;
        foreach ($dados as $dado) {
            //Verificando e guardando caso o dígito seja um ponto
            if ($dado == '.') {
                $ponto_virgula = 1;
                $posicao_casa_decimal = $posicao;
            }

            //Verificando e guardando caso o dígito seja uma vírgula
            if ($dado == ',') {
                $ponto_virgula = 2;
                $posicao_casa_decimal = $posicao;
            }

            $posicao++;
        }

        //Refazer valor retirando pontos/vírgulas nas separações de milhares
        $valor = '';

        //posição
        $posicao = 0;
        foreach ($dados as $dado) {
            //Se dígito for um ponto/vírgula
            if ($dado == '.' or $dado == ',') {
                //Se for o ponto/vírgula da casa decimal (concatenar ao valor)
                if ($posicao_casa_decimal == $posicao) {$valor .= $dado;}
            } else {
                //concatenar ao valor
                $valor .= $dado;
            }

            $posicao++;
        }

        //Se valor tem vírgula trocar por ponto
        if ($ponto_virgula == 2) {
            $valor = str_replace(',', '.', $valor);
        }

        //Retorna para guardar no banco de dados (999999.99)
        if ($op == 1) {
            $valor = number_format($valor, '2', '.', '');
        }

        //Retorna no formato BR (999.999,99)
        if ($op == 2) {
            $valor = number_format($valor, '2', ',', '.');
        }

        //Retorna no formato US (999,999.99)
        if ($op == 3) {
            $valor = number_format($valor, '2', '.', ',');
        }

        //Retorna no formato (999999,99)
        if ($op == 4) {
            $valor = number_format($valor, '2', ',', '');
        }

        echo $valor;
    });

    Route::get('/formata_data/{op}/{data}', function ($op, $data) {
        //Variáveis para formatar o retorno
        $dia = '';
        $mes = '';
        $ano = '';

        //Verificando recebimento da data
        if ($data == '') {
            $data = null;
        } else {
            //Retirando espaços
            $data = trim($data);
            $data = str_replace(" ", "", $data);

            //Formato: 9999-99-99
            if (is_numeric(substr($data, 0, 4)) and substr($data, 4, 1) == '-' and is_numeric(substr($data, 5, 2)) and substr($data, 7, 1) == '-' and is_numeric(substr($data, 8, 2))) {
                $dia = substr($data, 8, 2);
                $mes = substr($data, 5, 2);
                $ano = substr($data, 0, 4);
            }

            //Formato: 9999/99/99
            if (is_numeric(substr($data, 0, 4)) and substr($data, 4, 1) == '/' and is_numeric(substr($data, 5, 2)) and substr($data, 7, 1) == '/' and is_numeric(substr($data, 8, 2))) {
                $dia = substr($data, 8, 2);
                $mes = substr($data, 5, 2);
                $ano = substr($data, 0, 4);
            }

            //Formato: 99-99-9999
            if (is_numeric(substr($data, 0, 2)) and substr($data, 2, 1) == '-' and is_numeric(substr($data, 3, 2)) and substr($data, 5, 1) == '-' and is_numeric(substr($data, 6, 4))) {
                $dia = substr($data, 0, 2);
                $mes = substr($data, 3, 2);
                $ano = substr($data, 6, 4);
            }

            //Formato: 99/99/9999
            if (is_numeric(substr($data, 0, 2)) and substr($data, 2, 1) == '/' and is_numeric(substr($data, 3, 2)) and substr($data, 5, 1) == '/' and is_numeric(substr($data, 6, 4))) {
                $dia = substr($data, 0, 2);
                $mes = substr($data, 3, 2);
                $ano = substr($data, 6, 4);
            }
        }

        //Retorno
        if ($dia == '' or $mes == '' or $ano == '') {
            $data = null;
        } else {
            //Retorna no formato (99/99/9999)
            if ($op == 1) {$data = $dia.'/'.$mes.'/'.$ano;}

            //Retorna no formato (99-99-9999)
            if ($op == 2) {$data = $dia.'-'.$mes.'-'.$ano;}

            //Retorna no formato (9999/99/99)
            if ($op == 3) {$data = $ano.'/'.$mes.'/'.$dia;}

            //Retorna no formato (9999-99-99)
            if ($op == 4) {$data = $ano.'-'.$mes.'-'.$dia;}
        }

        echo $data;
    });
});
