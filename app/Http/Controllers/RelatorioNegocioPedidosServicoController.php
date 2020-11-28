<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLancamentoReceberRequest;
use App\Http\Requests\UpdateLancamentoReceberRequest;
use App\Repositories\PedidoRepository;
use App\Repositories\ProdutosRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\ItemRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;

class RelatorioNegocioPedidosServicoController extends Controller
{
    /** @var  itemRepository */
    private $itemRepository;
    /** @var  pedidoRepository */
    private $pedidoRepository;
    /** @var  clientesRepository */
    private $clientesRepository;
    /** @var  produtosRepository */
    private $produtoRepository;
   

    public function __construct(PedidoRepository $PedidoRepo, ClienteRepository $clientesRepo, ItemRepository $itemRepo, ProdutosRepository $produtoRepo)
    {
        $this->pedidoRepository = $PedidoRepo;
        $this->clientesRepository = $clientesRepo;
        $this->itemRepository = $itemRepo;
        $this->produtoRepository = $produtoRepo;
        $this->middleware('permission:relatorio_sumario_vendas', ['only' => ['index','relatorioServico','doRelatorioServico','show','edit', 'update']]); 

    }

    public function relatorioServico()
    {
        /** Titulo da página */
        $title = "Relatório - Sumário de Vendas";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioPedidosServico";

        $servicos = $this->produtoRepository->all();

        return view('relatorio.pedidosNegocioServico', compact('title', 'breadcrumb', 'servicos'));
    }

    public function doRelatorioServico(Request $request)
    {
        /** Titulo da página */
        $title = "Relatório - Sumário de Vendas";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioPedidosServico";

        $input       = $request->all();
        $pedidos     = $this->itemRepository->relatorioNegocioPedido($input);
        
        return view('relatorio.pedidosNnegocioServico_lista', compact('title', 'breadcrumb', 'pedidos', 'input'));
    }
}
