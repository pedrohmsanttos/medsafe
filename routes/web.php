<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Routers to errors
 */
Route::get('404', ['as' => '404', 'uses' => 'ErrorController@notFound']);
Route::get('405', ['as' => '405', 'uses' => 'ErrorController@methodNotAllowed']);
Route::get('500', ['as' => '500', 'uses' => 'ErrorController@fatal']);

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['firstlogin']], function () {

        /**
         * Página inicial
         */
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/meuperfil', 'HomeController@meuPerfil');

        /**
         * Página inicial
         */
        Route::get('/home', 'HomeController@index')->name('home');

        

        /**
         * CRUD: Clientes
         */
        Route::resource('clientes', 'ClienteController');

        /**
         * CRUD: Fornecedores
         */
        Route::resource('fornecedores', 'FornecedorController');

        /**
         *  CRUD: Seguradoras
         */
        Route::resource('seguradoras', 'SeguradoraController');

        /**
         * CRUD: Contas Bancarias
         */
        Route::resource('contasbancarias', 'ContaBancariaController');

        /**
         * CRUD: Plano de contas
         */
        Route::resource('planodecontas', 'PlanoDeContasController');

        /**
         * CRUD: Categoria de Produto
         */
        Route::resource('categoriaProdutos', 'CategoriaProdutosController');

        /**
         * CRUD: Tipo de Produto
         */
        Route::resource('tipoProdutos', 'TipoProdutosController');

        /**
         * CRUD: Produtos
         */
        Route::resource('produtos', 'ProdutosController');

        /*
    * CRUD: Novidades
     */
        Route::resource('novidades', 'NovidadeController');

        /**
         * CRUD: Forma de Pagamentos
         */
        Route::resource('formaDePagamentos', 'FormaDePagamentoController');

        /**
         * CRUD: Faturamento
         */
        Route::resource('faturamentos', 'FaturamentosController');

        /**
         * CRUD: Faturamento
         */
        Route::resource('faturamentos', 'FaturamentosController');


        /**
         * CRUD: Motivo Perda Negócio
         */
        Route::resource('motivoPerdaNegocios', 'MotivoPerdaNegocioController');

        /**
         * CRUD: Contratos
         */
        Route::resource('contratos', 'ContratoController');

        /**
         * CRUD: Organização
         */
        Route::resource('organizacaos', 'OrganizacaoController');

        /**
         * CRUD: Pessoa
         */
        Route::resource('pessoas', 'PessoaController');

        /**
         * CRUD: Negócio
         */
        Route::resource('negocios', 'NegocioController');
        Route::group(['prefix' => 'negocios'], function () {
            Route::get('/copia/{id}', 'NegocioController@copy');
        });

        /**
         * Transferência de dados
         */
        Route::group(['prefix' => 'transferir'], function () {
            Route::get('/negocios', 'NegocioController@transferir');
            Route::post('/negocios', 'NegocioController@doTransferir');
            Route::get('/pedidos', 'PedidoController@transferir');
            Route::post('/pedidos', 'PedidoController@doTransferir');
        });

        /**
         * CRUD: Produto Tipo Produto
         */
        Route::resource('produtoTipoProdutos', 'ProdutoTipoProdutoController');

        /**
         * CRUD: Status de pedidos
         */
        Route::resource('statusPedidos', 'StatusPedidoController');

        Route::group(['prefix' => 'negocios'], function () {
            Route::group(['prefix' => 'atividades'], function () {
                /**
                 * CRUD: Atividades
                 */
                Route::get('/{id}', 'AtividadeController@index');
                Route::get('/', 'AtividadeController@index');

                Route::get('/{id}/create', 'AtividadeController@create');

                Route::get('/{idNegocio}/{id}/edit', 'AtividadeController@edit');
            });

            /**
             * CRUD: perda de negocio
             */
            // Route::resource('perdaNegocios', 'PerdaNegocioController');
            Route::get('/{id}/perda', 'PerdaNegocioController@index');
            Route::get('/perda', 'PerdaNegocioController@index');
            Route::get('/{idNegocio}/perda/create', 'PerdaNegocioController@create');

            Route::get('/{id}/ganho', 'GanhoNegocioController@index');
            Route::get('/ganho', 'GanhoNegocioController@index');
            Route::get('/{idNegocio}/ganho/create', 'GanhoNegocioController@create');

            Route::resource('atividades', 'AtividadeController');
        });

        /**
         * CRUD: perda de negocio
         */
        Route::resource('perdaNegocios', 'PerdaNegocioController');

        Route::resource('atividades', 'AtividadeController');

        /**
         * CRUD: Tipo de Atividades
         */
        Route::resource('tipoAtividades', 'TipoAtividadeController');

        /**
         * CRUD: Perda de negocios
         */
        Route::resource('perdaNegocios', 'PerdaNegocioController');

        /**
         * CRUD: Tipo de ganho de negocios
         */
        Route::resource('ganhoNegocios', 'GanhoNegocioController');

        /**
         * CRUD: Tipo de pedidos
         */
        Route::resource('pedidos', 'PedidoController');
        Route::group(['prefix' => 'pedidos'], function () {
            Route::get('/copia/{id}', 'PedidoController@copy');
        });

        /**
         * CRUD: Tipo de pedido tipo produtos
         */
        Route::resource('pedidoTipoProdutos', 'PedidoTipoProdutoController');

        /**
         * CRUD: Tipo de lancamentos receberes
         */
        Route::resource('lancamentoRecebers', 'LancamentoReceberController');

        /**
         * CRUD: Tipo de negocio produtos
         */
        Route::resource('negocioProdutos', 'NegocioProdutoController');

        /**
         * CRUD: Tipo de permissoes
         */
        Route::resource('permissoes', 'PermissoesController');

        /**
         * CRUD: Usuários
         */
        Route::resource('usuarios', 'UsuarioController');

        /**
         * CONFIG: E-mails
         */
        Route::group(['prefix' => 'email'], function () {
            Route::get('/', 'MailController@configuracao');
            Route::get('/teste', 'MailController@teste');
            Route::put('/{id}', 'MailController@update');
        });

        /**
         * Relatórios
         */
        Route::group(['prefix' => 'relatorio'], function () {
            Route::get('/receber', 'RelatorioLancamentoReceberController@relatorio');
            Route::post('/receber', 'RelatorioLancamentoReceberController@doRelatorio');
            Route::get('/pagar', 'RelatorioLancamentoPagarController@relatorio');
            Route::post('/pagar', 'RelatorioLancamentoPagarController@doRelatorio');
            Route::get('/tesouraria', 'RelatorioTesourariaController@relatorio');
            Route::post('/tesouraria', 'RelatorioTesourariaController@doRelatorio');
            Route::get('/planocontas', 'RelatorioPlanoContasController@relatorio');
            Route::post('/planocontas', 'RelatorioPlanoContasController@doRelatorio');
            Route::get('/pedidosPeriodo', 'RelatorioPedidosController@relatorio');
            Route::post('/pedidosPeriodo', 'RelatorioPedidosController@doRelatorio');
            Route::get('/pedidosServico', 'RelatorioPedidosServicoController@relatorioServico');
            Route::post('/pedidosServico', 'RelatorioPedidosServicoController@doRelatorioServico');
            Route::get('/negocioPedidosServico', 'RelatorioNegocioPedidosServicoController@relatorioServico');
            Route::post('/negocioPedidosServico', 'RelatorioNegocioPedidosServicoController@doRelatorioServico');
            Route::get('/negociosPeriodo', 'RelatorioNegociosPeriodoController@relatorio');
            Route::post('/negociosPeriodo', 'RelatorioNegociosPeriodoController@doRelatorio');
            Route::get('/ativacoesPeriodo', 'RelatorioAtivacoesPeriodoController@relatorio');
            Route::post('/ativacoesPeriodo', 'RelatorioAtivacoesPeriodoController@doRelatorio');
        });

        /**
         * CRUD: Corretoras
         */
        Route::resource('corretoras', 'CorretoraController');

        /**
         * CRUD: Corretores
         */
        Route::resource('corretors', 'CorretorController');

        /**
         * CRUD: Lançamentos a pagar
         */
        Route::resource('lancamentosPagar', 'LancamentoPagarController');

        /**
         * CRUD: Baixa a receber
         */
        Route::resource('baixareceber', 'BaixaReceberController');

        /**
         * CRUD: Baixa a receber
         */
        Route::resource('baixapagar', 'BaixaPagarController');

        /**
         * CRUD: Usuários
         */
        Route::resource('tesourarias', 'TesourariaController');
    });

    /**
     * redefinir senha
     */
        
    Route::get('/redefinirsenha', ['uses'=>'UsuarioController@redefinirsenha']);
    Route::post('/redefinirsenha', ['uses'=>'UsuarioController@doRedefinirsenha']);
    /**
     * trocarperfil
     */
    Route::post('/trocarperfil', 'HomeController@trocarperfil');

    /**
     * Logout
     */
    Route::get('/sair', 'HomeController@logout');

    Route::resource('items', 'ItemController');

    Route::resource('checkouts', 'CheckoutController');


    Route::resource('categoriaTickets', 'CategoriaTicketController');

    Route::resource('commentTickets', 'CommentTicketController');

    Route::resource('tickets', 'TicketController');

    Route::resource('apolices', 'ApoliceController');

    Route::resource('beneficios', 'BeneficioController');

    Route::resource('coberturas', 'CoberturaController');
});

/** TODO: Route Auth
 * Login
 * Recupera senha
 * Reseta senha
 * Cadastro
 */

Auth::routes();


//Route::resource('contaTransactions', 'ContaTransactionController');


Route::resource('materials', 'MaterialController');
Route::group(['prefix' => 'materials'], function () {
    Route::get('/{idMaterial}/{id}/delete', 'MaterialController@deletar');
});

Route::resource('segurados', 'SeguradoController');

Route::resource('materialCorretors', 'MaterialCorretorController');

Route::resource('parametros', 'ParametroController');

Route::resource('renovacaos', 'RenovacaoController');

Route::resource('ocorrencias', 'OcorrenciaController');

Route::resource('especialidades', 'EspecialidadeController');

Route::resource('medsafeBeneficios', 'MedsafeBeneficioController');


Route::resource('corretoradms', 'CorretoradmController');

Route::resource('comissaos', 'ComissaoController');

Route::resource('materialItems', 'MaterialItemController');

Route::resource('perguntas', 'PerguntaController');