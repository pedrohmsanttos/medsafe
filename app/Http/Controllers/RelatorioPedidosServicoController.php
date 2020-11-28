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

class RelatorioPedidosServicoController extends Controller
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

        $this->middleware('permission:relatorio_pedido_servico', ['only' => ['index','relatorioServico','doRelatorioServico','show','edit', 'update']]); 

    }

    public function relatorioServico()
    {
        /** Titulo da página */
        $title = "Relatório - Pedido por Serviço";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioPedidosServico";

        $servicos = $this->produtoRepository->all();
        $clientes = $this->clientesRepository->all();

        return view('relatorio.pedidosServico', compact('title', 'breadcrumb', 'servicos', 'clientes'));
    }

    public function doRelatorioServico(Request $request)
    {
        /** Titulo da página */
        $title = "Relatório - Pedido por Serviço";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioPedidosServico";

        $input       = $request->all();
        $pedidos     = $this->itemRepository->relatorio($input);
        
        return view('relatorio.pedidosServico_lista', compact('title', 'breadcrumb', 'pedidos', 'input'));
    }
}
