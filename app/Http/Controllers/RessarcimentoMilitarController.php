<?php

namespace App\Http\Controllers;

use App\API\ApiReturn;
use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
use App\Models\RessarcimentoCobranca;
use App\Models\RessarcimentoConfiguracao;
use App\Models\RessarcimentoOrgao;
use App\Models\RessarcimentoReferencia;
use Illuminate\Http\Request;
use App\Models\RessarcimentoMilitar;
use Illuminate\Support\Facades\DB;

class RessarcimentoMilitarController extends Controller
{
    private $ressarcimento_militar;

    public function __construct(RessarcimentoMilitar $ressarcimento_militar)
    {
        $this->ressarcimento_militar = $ressarcimento_militar;
    }

    public function index()
    {
        $registros = $this->ressarcimento_militar->all();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function show($id)
    {
        try {
            $registro = $this->ressarcimento_militar->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, null);
            } else {
                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function auxiliary()
    {
        try {
            $registros = array();

            //Referências (com Cobranças abertas)'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Array para guardar as referencias para retorno
            $referencias = array();

            //varrer tabela ressarcimento_referencias
            $ressarcimento_referencias = RessarcimentoReferencia::orderby('referencia')->get();

            foreach ($ressarcimento_referencias as $ressarcimento_referencia) {
                if (RessarcimentoCobranca::where('cobranca_encerrada', 1)->where('referencia', $ressarcimento_referencia['referencia'])->count() == 0) {
                    array_push($referencias, ['referencia' => $ressarcimento_referencia['referencia']]);
                }
            }

            $registros['referencias'] = $referencias;
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registros);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function destroy($id)
    {
        try {
            $registro = $this->ressarcimento_militar->find($id);

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 4040, null, $registro);
            } else {
                //Verificar Lógica''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Não deixar excluir se Cobrança da Referência estiver fechada
                $cobrancaFechada = DB::table('ressarcimento_cobrancas')->where('cobranca_encerrada', 1)->where('referencia', $registro['referencia'])->count();

                if ($cobrancaFechada == 1) {
                    return $this->sendResponse('Náo é possível excluir. Cobrança fechada para a referência: '.SuporteFacade::getReferencia(1, $registro['referencia']), 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Verificar Relacionamentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                //Tabela Pagamentos
                if (SuporteFacade::verificarRelacionamento('ressarcimento_pagamentos', 'ressarcimento_militar_id', $id) > 0) {
                    return $this->sendResponse('Náo é possível excluir. Registro relacionado com Ressarcimento Pagamentos.', 2040, null, null);
                }
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                //Deletar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $registro->delete();

                return $this->sendResponse('Registro excluído com sucesso.', 2000, null, null);
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }

    public function filter($array_dados)
    {
        //Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        //Limpar Querys executadas
        //DB::enableQueryLog();


        //Registros
        $registros = $this->ressarcimento_militar
            ->select(['ressarcimento_militares.*'])
            ->where(function($query) use($filtros) {
                //Variavel para controle
                $qtdFiltros = count($filtros) / 4;
                $indexCampo = 0;

                for($i=1; $i<=$qtdFiltros; $i++) {
                    //Valores do Filtro
                    $condicao = $filtros[$indexCampo];
                    $campo = $filtros[$indexCampo+1];
                    $operacao = $filtros[$indexCampo+2];
                    $dado = $filtros[$indexCampo+3];
                    $dado = str_replace('xxbarrayy', '/', $dado);

                    //Operações
                    if ($operacao == 1) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado.'%');} else {$query->orwhere($campo, 'like', '%'.$dado.'%');}
                    }
                    if ($operacao == 2) {
                        if ($condicao == 1) {$query->where($campo, '=', $dado);} else {$query->orwhere($campo, '=', $dado);}
                    }
                    if ($operacao == 3) {
                        if ($condicao == 1) {$query->where($campo, '>', $dado);} else {$query->orwhere($campo, '>', $dado);}
                    }
                    if ($operacao == 4) {
                        if ($condicao == 1) {$query->where($campo, '>=', $dado);} else {$query->orwhere($campo, '>=', $dado);}
                    }
                    if ($operacao == 5) {
                        if ($condicao == 1) {$query->where($campo, '<', $dado);} else {$query->orwhere($campo, '<', $dado);}
                    }
                    if ($operacao == 6) {
                        if ($condicao == 1) {$query->where($campo, '<=', $dado);} else {$query->orwhere($campo, '<=', $dado);}
                    }
                    if ($operacao == 7) {
                        if ($condicao == 1) {$query->where($campo, 'like', $dado.'%');} else {$query->orwhere($campo, 'like', $dado.'%');}
                    }
                    if ($operacao == 8) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado);} else {$query->orwhere($campo, 'like', '%'.$dado);}
                    }

                    //Atualizar indexCampo
                    $indexCampo = $indexCampo + 4;
                }
            }
            )->get();

        //Código SQL Bruto
        //$sql = DB::getQueryLog();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function importar(Request $request)
    {
        try {
            //Verificar Lógica''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Não deixar importar se Cobrança da Referência estiver fechada
            $cobrancaFechada = DB::table('ressarcimento_cobrancas')->where('cobranca_encerrada', 1)->where('referencia', $request['referencia'])->count();

            if ($cobrancaFechada == 1) {
                return $this->sendResponse('Náo é possível importar. Cobrança fechada para a referência: '.SuporteFacade::getReferencia(1, $request['referencia']), 2040, null, null);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Array com Dados para inclusão
            $registro = array();

            $registro['referencia'] = utf8_decode($request['referencia']);
            $registro['identidade_funcional'] = utf8_decode(str_pad($request['identidade_funcional'], 10, '0', STR_PAD_LEFT));
            $registro['rg'] = utf8_decode($request['rg']);
            $registro['nome'] = utf8_decode($request['nome']);
            $registro['oficial_praca'] = utf8_decode($request['oficial_praca']);
            $registro['posto_graduacao'] = utf8_decode($request['posto_graduacao']);
            $registro['quadro_qbmp'] = utf8_decode($request['quadro_qbmp']);
            $registro['boletim'] = utf8_decode($request['boletim']);
            $registro['lotacao_id'] = utf8_decode($request['lotacao_id']);
            $registro['lotacao'] = utf8_decode($request['lotacao']);

            //Verificar se já foi importado
            $ja_importado = RessarcimentoMilitar::where('referencia', $registro['referencia'])->where('identidade_funcional', $registro['identidade_funcional'])->count();

            //Se não foi importado
            if ($ja_importado == 0) {
                //Incluindo registro
                $response = $this->ressarcimento_militar->create($registro);

                if ($response) {
                    //Gravar Órgão
                    $reg_existe = RessarcimentoOrgao::where('lotacao_id', $registro['lotacao_id'])->count();

                    if ($reg_existe == 1) {
                        RessarcimentoOrgao::where('lotacao_id', $registro['lotacao_id'])->update([
                            'lotacao' => $registro['lotacao']
                        ]);
                    } else {
                        $dadosOrgaos = [
                            431 => ['cnpj' => '','contato_nome' => 'Kleber Nunes de Vasconcellos','esfera_id' => '1','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '4','funcao_id' => '1','cep' => '20221260','numero' => '62','complemento' => '8º ANDAR','logradouro' => 'Palácio Duque de Caxias','bairro' => '','localidade' => 'RIO DE JANEIRO','uf' => 'RJ','contato_email' => ''],
                            305 => ['cnpj' => '','contato_nome' => 'Paulo Vinícius Cozzolino Abrahão','esfera_id' => '2','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '1','funcao_id' => '7','cep' => '20020080','numero' => '314','complemento' => '','logradouro' => 'Avenida Marechal Camara','bairro' => '','localidade' => 'RIO DE JANEIRO','uf' => 'RJ','contato_email' => ''],
                            295 => ['cnpj' => '','contato_nome' => 'Rodrigo Bacellar','esfera_id' => '2','poder_id' => '2','tratamento_id' => '3','vocativo_id' => '2','funcao_id' => '8','cep' => '20010090','numero' => '8','complemento' => '3º ANDAR (DGF - Sr. Lauro)','logradouro' => 'Rua da Alfândega','bairro' => '','localidade' => 'RIO DE JANEIRO','uf' => 'RJ','contato_email' => ''],
                            1342 => ['cnpj' => '1786029000103','contato_nome' => 'Wanderlei Barbosa Castro','esfera_id' => '2','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '5','funcao_id' => '9','cep' => '77001002','numero' => 's/n','complemento' => '','logradouro' => 'Praça dos Girassóis','bairro' => '','localidade' => 'PALMAS','uf' => 'TO','contato_email' => ''],
                            1286 => ['cnpj' => '33638099000100','contato_nome' => 'Washington Luiz Vaz Júnior','esfera_id' => '2','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '5','funcao_id' => '9','cep' => '74175120','numero' => '','complemento' => 'ESQ. C/ AVENIDA C-231','logradouro' => 'Av. C-206 - Jardim América ','bairro' => '','localidade' => 'Goiânia','uf' => 'GO','contato_email' => ''],
                            293 => ['cnpj' => '29468014000116','contato_nome' => 'Eduardo Paes','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '20211110','numero' => '455','complemento' => '10º ANDAR','logradouro' => 'Rua Afonso Cavalcanti','bairro' => '','localidade' => 'RIO DE JANEIRO','uf' => 'RJ','contato_email' => ''],
                            1328 => ['cnpj' => '29172467000109','contato_nome' => 'Cláudio de Lima Sírio Ferreti','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '23900900','numero' => '186','complemento' => '','logradouro' => 'Praça Nilo Peçanha','bairro' => '','localidade' => 'ANGRA DOS REIS','uf' => 'RJ','contato_email' => 'adpe@angra.rj.gov.br'],
                            463 => ['cnpj' => '','contato_nome' => 'Alexandre de Oliveira Martins','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28950000','numero' => '111','complemento' => '','logradouro' => 'Praça Santos Dumont','bairro' => '','localidade' => 'ARMAÇÃO DOS BÚZIOS','uf' => 'RJ','contato_email' => 'infraestrutura.adm@buzios.rj.gov.br'],
                            414 => ['cnpj' => '39485438000142','contato_nome' => 'Márcio Correia de Oliveira','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '26113340','numero' => '378','complemento' => '','logradouro' => 'Avenida Floripes Rocha','bairro' => '','localidade' => 'BELFORD ROXO','uf' => 'RJ','contato_email' => 'sec.fazenda@belfordroxo.rj.gov.br'],
                            415 => ['cnpj' => '28812972000108','contato_nome' => 'Paulo Sergio Cyrillo','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28360000','numero' => '68','complemento' => '','logradouro' => 'Avenida Governador Roberto Silveira','bairro' => '','localidade' => 'BOM JESUS DO ITABAPOANA','uf' => 'RJ','contato_email' => 'gabinete@bomjesus.rj.gov.br '],
                            1307 => ['cnpj' => '28549483000105','contato_nome' => 'Sérgio Luiz Costa Azevedo Filho','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28906200','numero' => '760','complemento' => '','logradouro' => 'Avenida Nossa Senhora da Assunção','bairro' => '','localidade' => 'CABO FRIO','uf' => 'RJ','contato_email' => 'prefeito@cabofrio.rj.gov.br'],
                            323 => ['cnpj' => '29111085000167','contato_nome' => 'Murillo Silva Defanti','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28430000','numero' => '120','complemento' => '','logradouro' => 'Praça Bandeira','bairro' => '','localidade' => 'CAMBUCI','uf' => 'RJ','contato_email' => 'gabinete@prefeituradecambuci.rj.gov.br'],
                            324 => ['cnpj' => '29116894000161','contato_nome' => 'Wladimir Barros Assed Matheus de Oliveira','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28040010','numero' => '47','complemento' => '','logradouro' => 'Rua Coronel Ponciano de Azeredo Furtado','bairro' => '','localidade' => 'CAMPOS DOS GOYTACAZES','uf' => 'RJ','contato_email' => 'centralatendimento.smf@campos.rj.gov.br'],
                            326 => ['cnpj' => '','contato_nome' => 'Christiane Miranda De Andrade Cordeiro','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '27998000','numero' => '15','complemento' => '','logradouro' => 'Avenida Getúlio Vargas','bairro' => '','localidade' => 'CARAPEBUS','uf' => 'RJ','contato_email' => ' semfaz@carapebus.rj.gov.br'],
                            329 => ['cnpj' => '28614865000167','contato_nome' => 'Leonan Lopes Melhorance','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28540000','numero' => '42','complemento' => '','logradouro' => 'Avenida Presidente Vargas','bairro' => '','localidade' => 'CORDEIRO','uf' => 'RJ','contato_email' => 'gabinete@cordeiro.rj.gov.br'],
                            406 => ['cnpj' => '','contato_nome' => 'Jonathas Monteiro Porto Neto','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '25215260','numero' => '260','complemento' => '','logradouro' => 'Alameda Dona Esmeralda','bairro' => '','localidade' => 'DUQUE DE CAXIAS','uf' => 'RJ','contato_email' => 'smps@duquedecaxias.rj.gov.br'],
                            494 => ['cnpj' => '','contato_nome' => 'Fabio De Oliveira Costa','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28960000','numero' => '3200','complemento' => '','logradouro' => 'Avenida Paulino Rodrigues de Souza','bairro' => '','localidade' => 'IGUABA GRANDE','uf' => 'RJ','contato_email' => 'ascom@iguaba.rj.gov.br'],
                            1318 => ['cnpj' => '28741080000155','contato_nome' => 'Marcelo Jandre Delaroli ','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '24800000','numero' => '97','complemento' => '','logradouro' => 'Praça Marechal Floriano Peixoto','bairro' => '','localidade' => 'ITABORAÍ','uf' => 'RJ','contato_email' => 'PREFEITOMARCELODELAROLI@ITABORAI.RJ.GOV.BR'],
                            1326 => ['cnpj' => '28916716000152','contato_nome' => 'Emanuel Medeiros da Silva','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28300000','numero' => '64','complemento' => '','logradouro' => 'Praça Getúlio Vargas','bairro' => '','localidade' => 'ITAPERUNA','uf' => 'RJ','contato_email' => 'contato@itaperuna.rj.gov.br'],
                            335 => ['cnpj' => '29115474000160','contato_nome' => 'Welberth Porto de Rezende ','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '27913080','numero' => '534','complemento' => '4º ANDAR','logradouro' => 'Avenida Presidente Sodré','bairro' => '','localidade' => 'MACAÉ','uf' => 'RJ','contato_email' => 'cac@macae.rj.gov.br'],
                            336 => ['cnpj' => '29138351000145','contato_nome' => 'Renato Cozzolino Harb','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '25900000','numero' => '137','complemento' => '','logradouro' => 'Praça Nilo Peçanha','bairro' => '','localidade' => 'MAGÉ','uf' => 'RJ','contato_email' => ' fazenda@mage.rj.gov.br'],
                            337 => ['cnpj' => '29138310000159','contato_nome' => ' Luiz Claudio Ribeiro ','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '23860000','numero' => '92','complemento' => '','logradouro' => 'Praça Robert Simões','bairro' => '','localidade' => 'MANGARATIBA','uf' => 'RJ','contato_email' => 'gabineteprefeito@mangaratiba.rj.gov.br'],
                            304 => ['cnpj' => '32415283000129','contato_nome' => 'Pedro Paulo Quinzinho','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '26900000','numero' => '375','complemento' => '','logradouro' => 'Rua Prefeito Manoel Guilherme Barbosa','bairro' => '','localidade' => 'MIGUEL PEREIRA','uf' => 'RJ','contato_email' => 'gabinete@miguelpereira.rj.gov.br'],
                            339 => ['cnpj' => '29114121000146','contato_nome' => 'Maria Alessandra Leite Freire ','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28460000','numero' => '171','complemento' => '','logradouro' => 'Praça Ary Parreiras','bairro' => '','localidade' => 'MIRACEMA','uf' => 'RJ','contato_email' => 'gabineteprefeito@miracema.rj.gov.br'],
                            1335 => ['cnpj' => '29138286000158','contato_nome' => 'Abraão David Neto','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '26520330','numero' => '401','complemento' => '','logradouro' => 'Avenida Mirandela','bairro' => '','localidade' => 'NILÓPOLIS','uf' => 'RJ','contato_email' => 'gabinete@nilopolis.rj.gov.br '],
                            1301 => ['cnpj' => '28521748000159','contato_nome' => 'Rodrigo Neves Barreto','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '24020206','numero' => '987','complemento' => '6º ANDAR','logradouro' => 'Rua Visconde de Sepetiba','bairro' => '','localidade' => 'NITERÓI','uf' => 'RJ','contato_email' => 'cac@fazenda.niteroi.rj.gov.br'],
                            341 => ['cnpj' => '28606630000123','contato_nome' => ' Johnny Maycon Cordeiro Ribeiro','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28613001','numero' => '225','complemento' => '','logradouro' => 'Avenida Alberto Braune','bairro' => '','localidade' => 'NOVA FRIBURGO','uf' => 'RJ','contato_email' => 'atendimentofinancaspmnf@gmail.com'],
                            386 => ['cnpj' => '29138278000101','contato_nome' => ' Eduardo Reina Gomes de Oliveira','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '26210190','numero' => '528','complemento' => '','logradouro' => 'Rua Dr Ataíde Pimenta de Moraes','bairro' => '','localidade' => 'NOVA IGUAÇU','uf' => 'RJ','contato_email' => 'gabinete.semif@novaiguacu.rj.gov.br'],
                            1292 => ['cnpj' => '29138294000102','contato_nome' => 'Lucimar Cristina Da Silva Ferreira','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '26600000','numero' => '50','complemento' => '','logradouro' => 'Rua Juiz Emílio Carmo','bairro' => '','localidade' => 'PARACAMBI','uf' => 'RJ','contato_email' => 'gabinete@paracambi.rj.gov.br'],
                            1320 => ['cnpj' => '31844889000117','contato_nome' => ' Julio Avelino Oliveira de Moura Júnior','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '26950000','numero' => '35','complemento' => '','logradouro' => 'Rua Sebastião de Lacerda','bairro' => '','localidade' => 'PATY DO ALFERES','uf' => 'RJ','contato_email' => 'gabinete@patydoalferes.rj.gov'],
                            433 => ['cnpj' => '29138344000143','contato_nome' => ' Hingo Hammes','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28685060','numero' => '260','complemento' => '','logradouro' => 'Av. Köeller','bairro' => '','localidade' => 'PETRÓPOLIS','uf' => 'RJ','contato_email' => 'sefnaa@petropolis.rj.gov.br'],
                            393 => ['cnpj' => '39485412000102','contato_nome' => 'Glauco Barbosa Hoffman Kaizer','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '26390180','numero' => '254','complemento' => '','logradouro' => 'Rua Hortência','bairro' => '','localidade' => 'QUEIMADOS','uf' => 'RJ','contato_email' => 'chefiadegabinete@queimados.rj.gov.br'],
                            1311 => ['cnpj' => '28741072000109','contato_nome' => 'Marcos Abrahão','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28800000','numero' => '23','complemento' => '','logradouro' => 'Rua Monsenhor Antônio de Souza Gens','bairro' => '','localidade' => 'RIO BONITO','uf' => 'RJ','contato_email' => 'planejamento@riobonito.rj.gov.br '],
                            348 => ['cnpj' => '39223581000166','contato_nome' => 'Carlos Augusto Carvalho Balthazar ','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '28890000','numero' => '75','complemento' => '','logradouro' => 'Rua Campo de Albacora','bairro' => '','localidade' => 'RIO DAS OSTRAS','uf' => 'RJ','contato_email' => 'gabinete@riodasostras.rj.gov.br'],
                            352 => ['cnpj' => '28636579000100','contato_nome' => 'Nelson Ruas dos Santos','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '24440440 ','numero' => '100','complemento' => '','logradouro' => 'Rua Feliciano Sodré','bairro' => '','localidade' => 'SÃO GONÇALO','uf' => 'RJ','contato_email' => 'procuradoriageral@pmsg.rj.gov.br'],
                            354 => ['cnpj' => '29138336000105','contato_nome' => 'Leonardo Vieira Mendes ','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '25555201','numero' => '899','complemento' => '1º ANDAR','logradouro' => 'Avenida Presidente Lincoln','bairro' => '','localidade' => 'SÃO JOÃO DE MERITI','uf' => 'RJ','contato_email' => ' pgm@meriti.rj.gov.br'],
                            443 => ['cnpj' => '','contato_nome' => 'Lucas Dutra Dos Santos','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '23835390','numero' => '18','complemento' => '','logradouro' => 'Rua Maria Lourenço','bairro' => '','localidade' => 'SEROPÉDICA','uf' => 'RJ','contato_email' => 'administracao@seropedica.rj.gov.br'],
                            1316 => ['cnpj' => '29138369000147','contato_nome' => 'Leonardo Vasconcellos','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '25963670','numero' => '675','complemento' => '2º ANDAR (FOLHA DE PAGAMENTO)','logradouro' => 'Avenida Feliciano Sodré','bairro' => '','localidade' => 'TERESÓPOLIS','uf' => 'RJ','contato_email' => 'prefeito@teresopolis.rj.gov.br'],
                            626 => ['cnpj' => '29138302000102','contato_nome' => 'Rubens Vieira de Souza','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '23815310','numero' => '636','complemento' => '','logradouro' => 'Rua General Bocaiúva','bairro' => '','localidade' => 'ITAGUAI','uf' => 'RJ','contato_email' => ''],
                            1291 => ['cnpj' => '29138385000130','contato_nome' => 'Júlio de Souza Bernardes','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '25850000','numero' => '106','complemento' => '','logradouro' => 'Rua Visconde da Paraíba','bairro' => '','localidade' => 'PARAÍBA DO SUL','uf' => 'RJ','contato_email' => 'governo@paraibadosul.rj.gov.br'],
                            1325 => ['cnpj' => '28576080000147','contato_nome' => 'Kátia Cristina Miki da Silva','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '6','funcao_id' => '10','cep' => '27135130','numero' => '47','complemento' => '','logradouro' => ' R. dos Praçinhas','bairro' => '','localidade' => 'Barra do Piraí','uf' => 'RJ','contato_email' => ''],
                            379 => ['cnpj' => '','contato_nome' => 'Márcio Henrique Cruz Pacheco','esfera_id' => '2','poder_id' => '2','tratamento_id' => '3','vocativo_id' => '7','funcao_id' => '10','cep' => '20211351','numero' => '70','complemento' => '5º ANDAR','logradouro' => 'Praça da República','bairro' => '','localidade' => 'RIO DE JANEIRO','uf' => 'RJ','contato_email' => ''],
                            380 => ['cnpj' => '','contato_nome' => 'Ricardo Couto de Castro','esfera_id' => '2','poder_id' => '3','tratamento_id' => '3','vocativo_id' => '3','funcao_id' => '11','cep' => '20020903','numero' => '2','complemento' => 'PRÉDIO DA CONAB','logradouro' => 'Praça XV de Novembro','bairro' => '','localidade' => 'RIO DE JANEIRO','uf' => 'RJ','contato_email' => ''],
                            887 => ['cnpj' => '32243347000151','contato_nome' => 'Luiz Paulo Araújo da Silva Filho','esfera_id' => '1','poder_id' => '3','tratamento_id' => '3','vocativo_id' => '3','funcao_id' => '11','cep' => '20090030','numero' => '46','complemento' => '','logradouro' => 'Rua Dom Gerardo','bairro' => '','localidade' => 'RIO DE JANEIRO','uf' => 'RJ','contato_email' => ''],
                            403 => ['cnpj' => '27532498000190','contato_nome' => 'Luiz Antônio Guaraná','esfera_id' => '3','poder_id' => '2','tratamento_id' => '3','vocativo_id' => '7','funcao_id' => '11','cep' => '20030042','numero' => '732','complemento' => '3º ANDAR','logradouro' => 'Rua Santa Luzia','bairro' => '','localidade' => 'RIO DE JANEIRO','uf' => 'RJ','contato_email' => ''],
                            321 => ['cnpj' => '','contato_nome' => 'Antonio José Campos Moreira ','esfera_id' => '2','poder_id' => '3','tratamento_id' => '3','vocativo_id' => '8','funcao_id' => '12','cep' => '20020080','numero' => '370','complemento' => '','logradouro' => 'Avenida Marechal Câmara','bairro' => '','localidade' => 'RIO DE JANEIRO','uf' => 'RJ','contato_email' => ''],
                            1290 => ['cnpj' => '39244595000166','contato_nome' => 'Ilza Fellows','esfera_id' => '3','poder_id' => '1','tratamento_id' => '3','vocativo_id' => '9','funcao_id' => '13','cep' => '24030079','numero' => '414','complemento' => '','logradouro' => 'R. Visc. do Uruguai','bairro' => '','localidade' => 'NITERÓI','uf' => 'RJ','contato_email' => ''],
                            1057 => ['cnpj' => '30467039000184','contato_nome' => 'Carlo Caiado','esfera_id' => '3','poder_id' => '2','tratamento_id' => '3','vocativo_id' => '10','funcao_id' => '14','cep' => '20031050','numero' => 's/nº','complemento' => 'TÉRREO','logradouro' => 'Rua Alcindo Guanabara','bairro' => '','localidade' => 'RIO DE JANEIRO','uf' => 'RJ','contato_email' => ''],
                            386 => ['cnpj' => '30635775000102','contato_nome' => 'Márcio Luiz Marques Guimarães','esfera_id' => '3','poder_id' => '2','tratamento_id' => '3','vocativo_id' => '10','funcao_id' => '14','cep' => '26210211','numero' => '38','complemento' => '','logradouro' => 'Rua Prefeito João Luiz do Nascimento','bairro' => '','localidade' => 'Nova Iguaçu','uf' => 'RJ','contato_email' => '']
                        ];

                        $dados = array();
                        $dados['name'] = $registro['lotacao'];
                        $dados['lotacao_id'] = $registro['lotacao_id'];
                        $dados['lotacao'] = $registro['lotacao'];

                        //Pesquisar no Array $dadosOrgaos
                        if (isset($dadosOrgaos[$registro['lotacao_id']])) {
                            $dados['cnpj'] = $dadosOrgaos[$registro['lotacao_id']]['cnpj'];
                            $dados['contato_nome'] = $dadosOrgaos[$registro['lotacao_id']]['contato_nome'];
                            $dados['esfera_id'] = $dadosOrgaos[$registro['lotacao_id']]['esfera_id'];
                            $dados['poder_id'] = $dadosOrgaos[$registro['lotacao_id']]['poder_id'];
                            $dados['tratamento_id'] = $dadosOrgaos[$registro['lotacao_id']]['tratamento_id'];
                            $dados['vocativo_id'] = $dadosOrgaos[$registro['lotacao_id']]['vocativo_id'];
                            $dados['funcao_id'] = $dadosOrgaos[$registro['lotacao_id']]['funcao_id'];
                            $dados['cep'] = $dadosOrgaos[$registro['lotacao_id']]['cep'];
                            $dados['numero'] = $dadosOrgaos[$registro['lotacao_id']]['numero'];
                            $dados['complemento'] = $dadosOrgaos[$registro['lotacao_id']]['complemento'];
                            $dados['logradouro'] = $dadosOrgaos[$registro['lotacao_id']]['logradouro'];
                            $dados['bairro'] = $dadosOrgaos[$registro['lotacao_id']]['bairro'];
                            $dados['localidade'] = $dadosOrgaos[$registro['lotacao_id']]['localidade'];
                            $dados['uf'] = $dadosOrgaos[$registro['lotacao_id']]['uf'];
                            $dados['contato_email'] = $dadosOrgaos[$registro['lotacao_id']]['contato_email'];
                        }

                        RessarcimentoOrgao::create($dados);
                    }

                    //Gravar Configuração (um registro para a referência)
                    $reg_existe = RessarcimentoConfiguracao::where('referencia', $registro['referencia'])->count();

                    if ($reg_existe == 0) {
                        $registros_configuracoes = RessarcimentoConfiguracao::orderby('referencia', 'desc')->get();

                        if ($registros_configuracoes->count() > 0) {
                            foreach ($registros_configuracoes as $reg) {
                                $configuracoes = array();
                                $configuracoes['referencia'] = $registro['referencia'];
                                $configuracoes['data_vencimento'] = $reg['data_vencimento'];

                                $configuracoes['diretor_identidade_funcional'] = $reg['diretor_identidade_funcional'];
                                $configuracoes['diretor_rg'] = $reg['diretor_rg'];
                                $configuracoes['diretor_nome'] = $reg['diretor_nome'];
                                $configuracoes['diretor_posto'] = $reg['diretor_posto'];
                                $configuracoes['diretor_quadro'] = $reg['diretor_quadro'];
                                $configuracoes['diretor_cargo'] = $reg['diretor_cargo'];

                                $configuracoes['dgf2_identidade_funcional'] = $reg['dgf2_identidade_funcional'];
                                $configuracoes['dgf2_rg'] = $reg['dgf2_rg'];
                                $configuracoes['dgf2_nome'] = $reg['dgf2_nome'];
                                $configuracoes['dgf2_posto'] = $reg['dgf2_posto'];
                                $configuracoes['dgf2_quadro'] = $reg['dgf2_quadro'];
                                $configuracoes['dgf2_cargo'] = $reg['dgf2_cargo'];

                                break;
                            }
                        } else {
                            $configuracoes = array();
                            $configuracoes['referencia'] = $registro['referencia'];
                        }

                        RessarcimentoConfiguracao::create($configuracoes);
                    }

                    //Return
                    return $this->sendResponse('Registro incluído com sucesso.', 2000, null, null);
                } else {
                    return $this->sendResponse($registro['nome'], 2005, null, null);
                }
            } else {
                return $this->sendResponse($registro['nome'], 2006, null, null);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($registro['nome'].'<br>'.$e->getMessage(), 2005, null, null);
            }

            return $this->sendResponse($registro['nome'], 2005, null, null);
        }
    }
}
