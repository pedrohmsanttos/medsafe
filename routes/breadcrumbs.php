<?php
    /**
     * Breadcrumbs to home page from dashboard MedSafer
     */
    Breadcrumbs::register('dashboard', function ($breadcrumbs) {
        $breadcrumbs->push('Página inicial', url("/"));
    });

    Breadcrumbs::register('meuperfil', function ($breadcrumbs, $options) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push("Meu Perfil", url("/meuperfil"));
    });

    /**
     * Breadcrumbs to User page from dashboard MedSafer
     */
    Breadcrumbs::register('usuarios', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Usuários', url("/meuperfil"));
    });

    Breadcrumbs::register('showUsuario', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('usuarios');
        $breadcrumbs->push($option->titulo, url("/usuarios/".$option->id));
    });

    Breadcrumbs::register('editUsuario', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('usuarios');
        $breadcrumbs->push($option->titulo, url("/usuarios/".$option->id."/edit"));
    });

    Breadcrumbs::register('addUsuario', function ($breadcrumbs) {
        $breadcrumbs->parent('usuarios');
        $breadcrumbs->push('Adicionar Usuario', url("/create"));
    });

    /**
     * Breadcrumbs to Clientes page from dashboard MedSafer
     */
    Breadcrumbs::register('clientes', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Clientes', url("/clientes"));
    });

    Breadcrumbs::register('showCliente', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('clientes');
        $breadcrumbs->push($option->titulo, url("/clientes/".$option->id));
    });

    Breadcrumbs::register('editCliente', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('clientes');
        $breadcrumbs->push($option->titulo, url("/clientes/".$option->id."/edit"));
    });

    Breadcrumbs::register('addCliente', function ($breadcrumbs) {
        $breadcrumbs->parent('clientes');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Fornecedores page from dashboard MedSafer
     */
    Breadcrumbs::register('fornecedores', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Fornecedores', url("/fornecedores"));
    });

    Breadcrumbs::register('showFornecedor', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('fornecedores');
        $breadcrumbs->push($option->titulo, url("/fornecedores/".$option->id));
    });

    Breadcrumbs::register('editFornecedor', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('fornecedores');
        $breadcrumbs->push($option->titulo, url("/fornecedores/".$option->id."/edit"));
    });

    Breadcrumbs::register('addFornecedor', function ($breadcrumbs) {
        $breadcrumbs->parent('fornecedores');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Seguradoras page from dashboard MedSafer
     */
    Breadcrumbs::register('seguradora', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Seguradora', url("/seguradoras"));
    });

    Breadcrumbs::register('showSeguradora', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('seguradora');
        $breadcrumbs->push($option->titulo, url("/seguradoras/".$option->id));
    });

    Breadcrumbs::register('editSeguradora', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('seguradora');
        $breadcrumbs->push($option->titulo, url("/seguradoras/".$option->id."/edit"));
    });

    Breadcrumbs::register('addSeguradora', function ($breadcrumbs) {
        $breadcrumbs->parent('seguradora');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Novidades page from dashboard MedSafer
     */
    Breadcrumbs::register('novidades', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Novidades', url("/novidades"));
    });

    Breadcrumbs::register('showNovidade', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('novidades');
        $breadcrumbs->push($option->titulo, url("/novidades/".$option->id));
    });

    Breadcrumbs::register('editNovidade', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('novidades');
        $breadcrumbs->push($option->titulo, url("/novidades/".$option->id."/edit"));
    });

    Breadcrumbs::register('addNovidade', function ($breadcrumbs) {
        $breadcrumbs->parent('novidades');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    
    /**
     * Breadcrumbs to Formas de Pagamento page from dashboard MedSafer
     */
    Breadcrumbs::register('formasDePagamento', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Formas de Pagamento', url("/formaDePagamentos"));
    });

    Breadcrumbs::register('showFormaDePagamento', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('formasDePagamento');
        $breadcrumbs->push($option->titulo, url("/formasDePagamento/".$option->id));
    });

    Breadcrumbs::register('editFormasDePagamento', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('formasDePagamento');
        $breadcrumbs->push($option->titulo, url("/formasDePagamento/".$option->id."/edit"));
    });

    Breadcrumbs::register('addFormaDePagamento', function ($breadcrumbs) {
        $breadcrumbs->parent('formasDePagamento');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Conta bancaria page from dashboard MedSafer
     */
    Breadcrumbs::register('contaBancarias', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Contas Bancárias', url("/contasbancarias"));
    });

    Breadcrumbs::register('showContaBancaria', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('contaBancarias');
        $breadcrumbs->push($option->titulo, url("/contasbancarias/".$option->id));
    });

    Breadcrumbs::register('editContaBancaria', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('contaBancarias');
        $breadcrumbs->push($option->titulo, url("/contasbancarias/".$option->id."/edit"));
    });

    Breadcrumbs::register('addContaBancaria', function ($breadcrumbs) {
        $breadcrumbs->parent('contaBancarias');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /*
     * Breadcrumbs to Categoria Produto page from dashboard MedSafer
     */
    Breadcrumbs::register('categoriaProduto', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Categoria de Produtos/Serviços', url("/categoriaProdutos"));
    });

    Breadcrumbs::register('showCategoriaProduto', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('categoriaProduto');
        $breadcrumbs->push($option->titulo, url("/categoriaProduto/".$option->id));
    });

    Breadcrumbs::register('editCategoriaProduto', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('categoriaProduto');
        $breadcrumbs->push($option->titulo, url("/categoriaProduto/".$option->id."/edit"));
    });

    Breadcrumbs::register('addCategoriaProduto', function ($breadcrumbs) {
        $breadcrumbs->parent('categoriaProduto');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Tipo Produto page from dashboard MedSafer
     */
    Breadcrumbs::register('tipoProduto', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Tipo de Produtos/Serviços', url("/tipoProdutos"));
    });

    Breadcrumbs::register('showTipoProduto', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('tipoProduto');
        $breadcrumbs->push($option->titulo, url("/tipoProduto/".$option->id));
    });

    Breadcrumbs::register('editTipoProduto', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('tipoProduto');
        $breadcrumbs->push($option->titulo, url("/tipoProduto/".$option->id."/edit"));
    });

    Breadcrumbs::register('addTipoProduto', function ($breadcrumbs) {
        $breadcrumbs->parent('tipoProduto');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Produto page from dashboard MedSafer
     */
    Breadcrumbs::register('produto', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Produtos/Serviços', url("/produtos"));
    });

    Breadcrumbs::register('showProduto', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('produto');
        $breadcrumbs->push($option->titulo, url("/produto/".$option->id));
    });

    Breadcrumbs::register('editProduto', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('produto');
        $breadcrumbs->push($option->titulo, url("/produto/".$option->id."/edit"));
    });

    Breadcrumbs::register('addProduto', function ($breadcrumbs) {
        $breadcrumbs->parent('produto');
        $breadcrumbs->push('Adicionar', url("/create"));
    });
    
    /**
     * Breadcrumbs to Produto page from dashboard MedSafer
     */
    Breadcrumbs::register('planodecontas', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Plano de Contas', url("/planodecontas"));
    });

    Breadcrumbs::register('showPlanodecontas', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('planodecontas');
        $breadcrumbs->push($option->titulo, url("/planodecontas/".$option->id));
    });

    Breadcrumbs::register('editPlanodecontas', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('planodecontas');
        $breadcrumbs->push($option->titulo, url("/planodecontas/".$option->id."/edit"));
    });

    Breadcrumbs::register('addPlanodecontas', function ($breadcrumbs) {
        $breadcrumbs->parent('planodecontas');
        $breadcrumbs->push('Adicionar', url("/create"));
    });
    /**
     * Breadcrumbs to Faturamento page from dashboard MedSafer
     */
    Breadcrumbs::register('faturamento', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Faturamento', url("/faturamentos"));
    });

    Breadcrumbs::register('showFaturamento', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('faturamento');
        $breadcrumbs->push($option->titulo, url("/faturamento/".$option->id));
    });

    Breadcrumbs::register('editFaturamento', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('faturamento');
        $breadcrumbs->push($option->titulo, url("/faturamento/".$option->id."/edit"));
    });

    Breadcrumbs::register('addFaturamento', function ($breadcrumbs) {
        $breadcrumbs->parent('faturamento');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Negocio page from dashboard MedSafer
     */
    Breadcrumbs::register('negocio', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Negócios', url("/negocios"));
    });

    Breadcrumbs::register('showNegocio', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('negocio');
        $breadcrumbs->push($option->titulo, url("/negocio/".$option->id));
    });

    Breadcrumbs::register('editNegocio', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('negocio');
        $breadcrumbs->push($option->titulo, url("/negocio/".$option->id."/edit"));
    });

    Breadcrumbs::register('addNegocio', function ($breadcrumbs) {
        $breadcrumbs->parent('negocio');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Produto Tipo Produto page from dashboard MedSafer
     */
    Breadcrumbs::register('produtotipoproduto', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Tabela de Preço', url("/produtoTipoProdutos"));
    });

    Breadcrumbs::register('showProdutoTipoProduto', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('produtotipoproduto');
        $breadcrumbs->push($option->titulo, url("/produtotipoproduto/".$option->id));
    });

    Breadcrumbs::register('editProdutoTipoProduto', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('produtotipoproduto');
        $breadcrumbs->push($option->titulo, url("/produtotipoproduto/".$option->id."/edit"));
    });

    Breadcrumbs::register('addProdutoTipoProduto', function ($breadcrumbs) {
        $breadcrumbs->parent('produtotipoproduto');
        $breadcrumbs->push('Adicionar', url("/create"));
    });
    
    /**
     * Breadcrumbs to Motivo Perda Negocio page from dashboard MedSafer
     */
    Breadcrumbs::register('motivoPerdaNegocio', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Motivo de Perda de Negócio', url("/motivoPerdaNegocios"));
    });

    Breadcrumbs::register('showMotivoPerdaNegocio', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('motivoPerdaNegocio');
        $breadcrumbs->push($option->titulo, url("/motivoPerdaNegocio/".$option->id));
    });

    Breadcrumbs::register('editMotivoPerdaNegocio', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('motivoPerdaNegocio');
        $breadcrumbs->push($option->titulo, url("/motivoPerdaNegocio/".$option->id."/edit"));
    });

    Breadcrumbs::register('addMotivoPerdaNegocio', function ($breadcrumbs) {
        $breadcrumbs->parent('motivoPerdaNegocio');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Contrato page from dashboard MedSafer
     */
    Breadcrumbs::register('contratos', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Contratos', url("/contratos"));
    });

    Breadcrumbs::register('showContrato', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('contratos');
        $breadcrumbs->push($option->titulo, url("/contrato/".$option->id));
    });

    Breadcrumbs::register('editContrato', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('contratos');
        $breadcrumbs->push($option->titulo, url("/contrato/".$option->id."/edit"));
    });

    Breadcrumbs::register('addContrato', function ($breadcrumbs) {
        $breadcrumbs->parent('contratos');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Atividade page from dashboard MedSafer
     */
    Breadcrumbs::register('Atividade', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Atividade', url("/atividades"));
    });

    Breadcrumbs::register('showAtividade', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Atividade');
        $breadcrumbs->push($option->titulo, url("/atividades/".$option->id));
    });

    Breadcrumbs::register('editAtividade', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Atividade');
        $breadcrumbs->push($option->titulo, url("/atividades/".$option->id."/edit"));
    });

    Breadcrumbs::register('addAtividade', function ($breadcrumbs) {
        $breadcrumbs->parent('Atividade');
        $breadcrumbs->push('Adicionar', url("/create"));
    });
    
    /*
     * Breadcrumbs to Perda Negocio page from dashboard MedSafer
     */
    Breadcrumbs::register('PerdaNegocio', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Perda de Negócios', url("/negocios"));
    });

    Breadcrumbs::register('showPerdaNegocio', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('PerdaNegocio');
        $breadcrumbs->push($option->titulo, url("/perdaNegocios/".$option->id));
    });

    Breadcrumbs::register('editPerdaNegocio', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('PerdaNegocio');
        $breadcrumbs->push($option->titulo, url("/perdaNegocios/".$option->id."/edit"));
    });

    Breadcrumbs::register('addPerdaNegocio', function ($breadcrumbs) {
        $breadcrumbs->parent('PerdaNegocio');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /*
     * Breadcrumbs to Ganho Negocio page from dashboard MedSafer
     */
    Breadcrumbs::register('GanhoNegocio', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Ganho de Negócios', url("/negocios"));
    });

    Breadcrumbs::register('showGanhoNegocio', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('GanhoNegocio');
        $breadcrumbs->push($option->titulo, url("/ganhoNegocios/".$option->id));
    });

    Breadcrumbs::register('editGanhoNegocio', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('GanhoNegocio');
        $breadcrumbs->push($option->titulo, url("/ganhoNegocios/".$option->id."/edit"));
    });

    Breadcrumbs::register('addGanhoNegocio', function ($breadcrumbs) {
        $breadcrumbs->parent('GanhoNegocio');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Permissões page from dashboard MedSafer
     */
    Breadcrumbs::register('Permissoes', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Permissões', url("/permissoes"));
    });

    Breadcrumbs::register('showPermissoe', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Permissoes');
        $breadcrumbs->push($option->titulo, url("/permissoes/".$option->id));
    });

    Breadcrumbs::register('editPermissoes', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Permissoes');
        $breadcrumbs->push($option->titulo, url("/permissoes/".$option->id."/edit"));
    });

    Breadcrumbs::register('addPermissoes', function ($breadcrumbs) {
        $breadcrumbs->parent('Permissoes');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Usuários page from dashboard MedSafer
     */
    Breadcrumbs::register('Usuario', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Usuários', url("/usuarios"));
    });

    Breadcrumbs::register('editUsuarios', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Usuario');
        $breadcrumbs->push($option->titulo, url("/usuarios/".$option->id."/edit"));
    });

    Breadcrumbs::register('addUsuarios', function ($breadcrumbs) {
        $breadcrumbs->parent('Usuario');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to emails config
     */
    Breadcrumbs::register('mensagens_email', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Mensagens de Email', url('/email/'));
    });


    /**
     * Breadcrumbs to Lancamento Receber page from dashboard MedSafer
     */
    Breadcrumbs::register('lancamentoRecebers', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Lançamento a Receber', url("/lancamentoRecebers"));
    });

    Breadcrumbs::register('showLancamentoRecebers', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('lancamentoRecebers');
        $breadcrumbs->push($option->titulo, url("/lancamentoRecebers/".$option->id));
    });

    Breadcrumbs::register('editLancamentoRecebers', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('lancamentoRecebers');
        $breadcrumbs->push($option->titulo, url("/lancamentoRecebers/".$option->id."/edit"));
    });

    Breadcrumbs::register('addLancamentoRecebers', function ($breadcrumbs) {
        $breadcrumbs->parent('lancamentoRecebers');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    Breadcrumbs::register('relatorioLancamentoRecebers', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Relatório - Lançamentos e baixas a receber', url("/relatorio/receber"));
    });

    Breadcrumbs::register('relatorioTesouraria', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Relatório - Tesouraria', url("/relatorio/tesouraria"));
    });

    Breadcrumbs::register('relatorioLancamentoPagar', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Relatório - Lançamentos e baixas a pagar', url("/relatorio/pagar"));
    });

    Breadcrumbs::register('relatorioPlanoContas', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Relatório - Plano de Contas', url("/relatorio/receber"));
    });

    Breadcrumbs::register('relatorioPedidosPeriodo', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Relatório - Pedidos por Período', url("/relatorio/pedidosPeriodo"));
    });

    Breadcrumbs::register('relatorioPedidosServico', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Relatório - Pedidos por Serviço', url("/relatorio/pedidosServico"));
    });

    Breadcrumbs::register('relatorioNegociosPeriodo', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Relatório - Negócios por Período', url("/relatorio/negociosPeriodo"));
    });

    Breadcrumbs::register('relatorioAtivacoesPeriodo', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Relatório - Ativações por Período', url("/relatorio/ativacoesPeriodo"));
    });

    /**
     * Breadcrumbs to Status do Pedido page from dashboard MedSafer
     */
    Breadcrumbs::register('statusPedidos', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Status dos Pedidos ', url("/statusPedidos"));
    });

    Breadcrumbs::register('showStatusPedido', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('statusPedidos');
        $breadcrumbs->push($option->titulo, url("/statusPedidos/".$option->id));
    });

    Breadcrumbs::register('editStatusPedido', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('statusPedidos');
        $breadcrumbs->push($option->titulo, url("/statusPedidos/".$option->id."/edit"));
    });

    Breadcrumbs::register('addStatusPedido', function ($breadcrumbs) {
        $breadcrumbs->parent('statusPedidos');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Lancamento Pagar page from dashboard MedSafer
     */
    Breadcrumbs::register('lancamentosPagar', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Lançamento a Pagar', url("/lancamentosPagar"));
    });

    Breadcrumbs::register('showLancamentoPagar', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('lancamentosPagar');
        $breadcrumbs->push($option->titulo, url("/lancamentosPagar/".$option->id));
    });

    Breadcrumbs::register('editLancamentoPagar', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('lancamentosPagar');
        $breadcrumbs->push($option->titulo, url("/lancamentosPagar/".$option->id."/edit"));
    });

    Breadcrumbs::register('addLancamentoPagar', function ($breadcrumbs) {
        $breadcrumbs->parent('lancamentosPagar');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Tesouraria page from dashboard MedSafer
     */
    Breadcrumbs::register('tesourarias', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Tesouraria', url("/tesourarias"));
    });

    Breadcrumbs::register('showTesouraria', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('tesourarias');
        $breadcrumbs->push($option->titulo, url("/tesourarias/".$option->id));
    });

    Breadcrumbs::register('editTesouraria', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('tesourarias');
        $breadcrumbs->push($option->titulo, url("/tesourarias/".$option->id."/edit"));
    });

    Breadcrumbs::register('addTesouraria', function ($breadcrumbs) {
        $breadcrumbs->parent('tesourarias');
        $breadcrumbs->push('Adicionar', url("/tesourarias/create"));
    });

    /*
    * Breadcrumbs to baixa Pagar page from dashboard MedSafer
    */
    Breadcrumbs::register('baixaPagar', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Baixa de Lançamento a Pagar', url("/baixapagar"));
    });

    Breadcrumbs::register('showbaixaPagar', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('baixaPagar');
        $breadcrumbs->push($option->titulo, url("/baixapagar/".$option->id));
    });

    Breadcrumbs::register('editbaixaPagar', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('baixaPagar');
        $breadcrumbs->push($option->titulo, url("/baixapagar/".$option->id."/edit"));
    });

    Breadcrumbs::register('addbaixaPagar', function ($breadcrumbs) {
        $breadcrumbs->parent('baixaPagar');
        $breadcrumbs->push('Adicionar', url("/baixapagar/create"));
    });

    /**
     * Breadcrumbs to Baixa receber page from dashboard MedSafer
     */
    Breadcrumbs::register('baixaReceber', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Baixa de Contas a Receber', url("/baixareceber"));
    });

    Breadcrumbs::register('showbaixaReceber', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('baixaReceber');
        $breadcrumbs->push($option->titulo, url("/baixareceber/".$option->id));
    });

    Breadcrumbs::register('editbaixaReceber', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('baixaReceber');
        $breadcrumbs->push($option->titulo, url("/baixareceber/".$option->id."/edit"));
    });

    Breadcrumbs::register('addbaixaReceber', function ($breadcrumbs) {
        $breadcrumbs->parent('baixaReceber');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Pedido Tipo Produto page from dashboard MedSafer
     */
    Breadcrumbs::register('pedidotipoproduto', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Pedidos', url("/pedidoTipoProdutos"));
    });

    Breadcrumbs::register('showPedidoTipoProduto', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('pedidotipoproduto');
        $breadcrumbs->push($option->titulo, url("/pedidoTipoProduto/".$option->id));
    });

    Breadcrumbs::register('editPedidoTipoProduto', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('pedidotipoproduto');
        $breadcrumbs->push($option->titulo, url("/pedidoTipoProduto/".$option->id."/edit"));
    });

    Breadcrumbs::register('addPedidoTipoProduto', function ($breadcrumbs) {
        $breadcrumbs->parent('pedidotipoproduto');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

     /**
     * Breadcrumbs to Tipos Atividade page from dashboard MedSafer
     */
    Breadcrumbs::register('TipoAtividade', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Tipos de Atividade', url("/tipoAtividades"));
    });

    Breadcrumbs::register('showTipoAtividade', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('TipoAtividade');
        $breadcrumbs->push($option->titulo, url("/tipoAtividades/".$option->id));
    });

    Breadcrumbs::register('editTipoAtividade', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('TipoAtividade');
        $breadcrumbs->push($option->titulo, url("/tipoAtividades/".$option->id."/edit"));
    });

    Breadcrumbs::register('addTipoAtividade', function ($breadcrumbs) {
        $breadcrumbs->parent('TipoAtividade');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

     /**
     * Breadcrumbs to Pedido page from dashboard MedSafer
     */
    Breadcrumbs::register("Pedido", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Pedidos', url("/pedidos"));
    });

    Breadcrumbs::register('showPedido', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Pedido');
        $breadcrumbs->push($option->titulo, url("/pedidos/".$option->id));
    });

    Breadcrumbs::register('editPedido', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Pedido');
        $breadcrumbs->push($option->titulo, url("/pedidos/".$option->id."/edit"));
    });

    Breadcrumbs::register('addPedido', function ($breadcrumbs) {
        $breadcrumbs->parent('Pedido');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Checkout page from dashboard MedSafer
     */
    Breadcrumbs::register("Checkout", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Checkouts', url("/pedidos"));
    });

    Breadcrumbs::register('showCheckout', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Checkout');
        $breadcrumbs->push($option->titulo, url("/pedidos/".$option->id));
    });

    Breadcrumbs::register('editCheckout', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Checkout');
        $breadcrumbs->push($option->titulo, url("/pedidos/".$option->id."/edit"));
    });

    Breadcrumbs::register('addCheckout', function ($breadcrumbs) {
        $breadcrumbs->parent('Checkout');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Ticket page from dashboard MedSafer
     */
    Breadcrumbs::register("Ticket", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Atendimentos', url("/tickets"));
    });

    Breadcrumbs::register('showTicket', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Ticket');
        $breadcrumbs->push($option->titulo, url("/tickets/".$option->id));
    });

    Breadcrumbs::register('editTicket', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Ticket');
        $breadcrumbs->push($option->titulo, url("/tickets/".$option->id."/edit"));
    });

    Breadcrumbs::register('addTicket', function ($breadcrumbs) {
        $breadcrumbs->parent('Ticket');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Categoria of Ticket page from dashboard MedSafer
     */
    Breadcrumbs::register("CategoriaTicket", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Categorias de Solicitações', url("/categoriaTickets"));
    });

    Breadcrumbs::register('showCategoriaTicket', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('CategoriaTicket');
        $breadcrumbs->push($option->titulo, url("/categoriaTickets/".$option->id));
    });

    Breadcrumbs::register('editCategoriaTicket', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('CategoriaTicket');
        $breadcrumbs->push($option->titulo, url("/categoriaTickets/".$option->id."/edit"));
    });

    Breadcrumbs::register('addCategoriaTicket', function ($breadcrumbs) {
        $breadcrumbs->parent('CategoriaTicket');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Apolices
     */
    Breadcrumbs::register("Apolice", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Apolices', url("/apolices"));
    });

    Breadcrumbs::register('showApolice', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Apolice');
        $breadcrumbs->push($option->titulo, url("/apolices/".$option->id));
    });

    Breadcrumbs::register('editApolice', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Apolice');
        $breadcrumbs->push($option->titulo, url("/apolices/".$option->id."/edit"));
    });

    Breadcrumbs::register('addApolice', function ($breadcrumbs) {
        $breadcrumbs->parent('Apolice');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Benefício
     */
    Breadcrumbs::register("Benefício", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Benefício', url("/apolices"));
    });

    Breadcrumbs::register('showBenefício', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Benefício');
        $breadcrumbs->push($option->titulo, url("/apolices/".$option->id));
    });

    Breadcrumbs::register('editBenefício', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Benefício');
        $breadcrumbs->push($option->titulo, url("/apolices/".$option->id."/edit"));
    });

    Breadcrumbs::register('addBenefício', function ($breadcrumbs) {
        $breadcrumbs->parent('Benefício');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Material
     */
    Breadcrumbs::register("Material", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Material', url("/materials"));
    });

    Breadcrumbs::register('showMaterial', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Material');
        $breadcrumbs->push($option->titulo, url("/materials/".$option->id));
    });

    Breadcrumbs::register('editMaterial', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Material');
        $breadcrumbs->push($option->titulo, url("/materials/".$option->id."/edit"));
    });

    Breadcrumbs::register('addMaterial', function ($breadcrumbs) {
        $breadcrumbs->parent('Material');
        $breadcrumbs->push('Adicionar', url("/create"));
    });


    /**
     * Breadcrumbs to Segurado
     */
    Breadcrumbs::register("Segurado", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Segurado', url("/segurados"));
    });

    Breadcrumbs::register('showSegurado', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Segurado');
        $breadcrumbs->push($option->titulo, url("/segurados/".$option->id));
    });

    Breadcrumbs::register('editSegurado', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Segurado');
        $breadcrumbs->push($option->titulo, url("/segurados/".$option->id."/edit"));
    });

    Breadcrumbs::register('addSegurado', function ($breadcrumbs) {
        $breadcrumbs->parent('Segurado');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to MaterialCorretor
     */
    
    Breadcrumbs::register('MaterialCorretor', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Ganho de Negócios', url("/materialCorretors"));
    });

    Breadcrumbs::register('showMaterialCorretor', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('MaterialCorretor');
        $breadcrumbs->push($option->titulo, url("/materialCorretors/".$option->id));
    });

    Breadcrumbs::register('editMaterialCorretor', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('MaterialCorretor');
        $breadcrumbs->push($option->titulo, url("/materialCorretors/".$option->id."/edit"));
    });

    Breadcrumbs::register('addMaterialCorretor', function ($breadcrumbs) {
        $breadcrumbs->parent('MaterialCorretor');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Parametro
     */

    Breadcrumbs::register("Parametro", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Parametro', url("/parametros"));
    });

    Breadcrumbs::register('showParametro', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Parametro');
        $breadcrumbs->push($option->titulo, url("/parametros/".$option->id));
    });

    Breadcrumbs::register('editParametro', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Parametro');
        $breadcrumbs->push($option->titulo, url("/parametros/".$option->id."/edit"));
    });

    // Breadcrumbs::register('addParametro', function ($breadcrumbs) {
    //     $breadcrumbs->parent('Parametro');
    //     $breadcrumbs->push('Adicionar', url("/create"));
    // });

    /**
     * Breadcrumbs to Renovacao
     */

    Breadcrumbs::register("Renovacao", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Renovacao', url("/renovacaos"));
    });

    Breadcrumbs::register('showRenovacao', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Renovacao');
        $breadcrumbs->push($option->titulo, url("/renovacaos/".$option->id));
    });

    Breadcrumbs::register('editRenovacao', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Renovacao');
        $breadcrumbs->push($option->titulo, url("/renovacaos/".$option->id."/edit"));
    });

    Breadcrumbs::register('addRenovacao', function ($breadcrumbs) {
        $breadcrumbs->parent('Renovacao');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Ocorrencia
     */

    Breadcrumbs::register("Ocorrencia", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Ocorrencia', url("/ocorrencias"));
    });

    Breadcrumbs::register('showOcorrencia', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Ocorrencia');
        $breadcrumbs->push($option->titulo, url("/ocorrencias/".$option->id));
    });

    Breadcrumbs::register('editOcorrencia', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Ocorrencia');
        $breadcrumbs->push($option->titulo, url("/ocorrencias/".$option->id."/edit"));
    });

    Breadcrumbs::register('addOcorrencia', function ($breadcrumbs) {
        $breadcrumbs->parent('Ocorrencia');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to medsafeBeneficio
     */

    Breadcrumbs::register("Benefícios MEDSafer", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Benefícios MEDSafer', url("/medsafeBeneficios"));
    });

    Breadcrumbs::register('showBeneficios', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Benefícios MEDSafer');
        $breadcrumbs->push($option->titulo, url("/medsafeBeneficios/".$option->id));
    });

    Breadcrumbs::register('editBeneficios', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Benefícios MEDSafer');
        $breadcrumbs->push($option->titulo, url("/medsafeBeneficios/".$option->id."/edit"));
    });

    Breadcrumbs::register('addBeneficios', function ($breadcrumbs) {
        $breadcrumbs->parent('Benefícios MEDSafer');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to medsafeBeneficio
     */

    Breadcrumbs::register("Especialidade", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Especialidade', url("/especialidades"));
    });

    Breadcrumbs::register('showEspecialidade', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Especialidade');
        $breadcrumbs->push($option->titulo, url("/especialidades/".$option->id));
    });

    Breadcrumbs::register('editEspecialidade', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Especialidade');
        $breadcrumbs->push($option->titulo, url("/especialidades/".$option->id."/edit"));
    });

    Breadcrumbs::register('addEspecialidade', function ($breadcrumbs) {
        $breadcrumbs->parent('Especialidade');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to CorretorAdm
     */

    Breadcrumbs::register("Corretoradm", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Corretoradm', url("/corretoradms"));
    });

    Breadcrumbs::register('showCorretoradm', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Corretoradm');
        $breadcrumbs->push($option->titulo, url("/corretoradms/".$option->id));
    });

    Breadcrumbs::register('editCorretoradm', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Corretoradm');
        $breadcrumbs->push($option->titulo, url("/corretoradms/".$option->id."/edit"));
    });

    Breadcrumbs::register('addCorretoradm', function ($breadcrumbs) {
        $breadcrumbs->parent('Corretoradm');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Comissões
     */

    Breadcrumbs::register("Comissao", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Comissao', url("/comissaos"));
    });

    Breadcrumbs::register('showComissao', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Comissao');
        $breadcrumbs->push($option->titulo, url("/comissaos/".$option->id));
    });

    Breadcrumbs::register('editComissao', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Comissao');
        $breadcrumbs->push($option->titulo, url("/comissaos/".$option->id."/edit"));
    });

    Breadcrumbs::register('addComissao', function ($breadcrumbs) {
        $breadcrumbs->parent('Comissao');
        $breadcrumbs->push('Adicionar', url("/create"));
    });

    /**
     * Breadcrumbs to Pergunta
     */
    Breadcrumbs::register("Pergunta", function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Pergunta', url("/perguntas"));
    });

    Breadcrumbs::register('showPergunta', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Pergunta');
        $breadcrumbs->push($option->titulo, url("/perguntas/".$option->id));
    });

    Breadcrumbs::register('editPergunta', function ($breadcrumbs, $option) {
        $breadcrumbs->parent('Pergunta');
        $breadcrumbs->push($option->titulo, url("/perguntas/".$option->id."/edit"));
    });

    Breadcrumbs::register('addPergunta', function ($breadcrumbs) {
        $breadcrumbs->parent('Pergunta');
        $breadcrumbs->push('Adicionar', url("/create"));
    });




