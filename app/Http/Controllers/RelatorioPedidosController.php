<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLancamentoReceberRequest;
use App\Http\Requests\UpdateLancamentoReceberRequest;
use App\Repositories\PedidoRepository;
use App\Repositories\ClienteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;

class RelatorioPedidosController extends Controller
{
    /** @var  pedidoRepository */
    private $pedidoRepository;
    /** @var  clientesRepository */
    private $clientesRepository;

    public function __construct(PedidoRepository $PedidoRepo, ClienteRepository $clientesRepo)
    {
        $this->pedidoRepository = $PedidoRepo;
        $this->clientesRepository = $clientesRepo;
        $this->middleware('permission:relatorio_pedido_periodo', ['only' => ['index','relatorio','doRelatorio','show','edit', 'update']]); 

    }

    public function relatorio()
    {
        /** Titulo da página */
        $title = "Relatório - Pedido por Período";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioPedidosPeriodo";

        $clientes = $this->clientesRepository->all(); // Todos os clientes, para o filtro

        return view('relatorio.pedidos', compact('title', 'breadcrumb', 'clientes'));
    }

    public function doRelatorio(Request $request)
    {
        /** Titulo da página */
        $title = "Relatório - Pedido por Período";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioPedidosPeriodo";

        $input       = $request->all();
        $pedidos = $this->pedidoRepository->relatorio($input);
        
        return view('relatorio.pedidos_lista', compact('title', 'breadcrumb', 'pedidos', 'input'));
    }
}
