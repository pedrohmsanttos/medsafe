<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCheckoutRequest;
use App\Http\Requests\UpdateCheckoutRequest;
use App\Repositories\CheckoutRepository;
use App\Repositories\ClienteRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PedidoRepository;
use App\Repositories\LancamentoReceberRepository;
use Illuminate\Http\Request;
use App\Traits\CheckoutTrait;
use Flash;
use App\Models\LancamentoReceber;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;

class CheckoutController extends AppBaseController
{
    /** @var  CheckoutRepository */
    private $checkoutRepository;

    /** @var  PedidoRepository */
    private $pedidoRepository;

    /** @var  ClienteRepository */
    private $clienteRepository;

    /** @var  LancamentoReceberRepository */
    private $lancamentoReceberRepository;

    use CheckoutTrait;

    public function __construct(
        CheckoutRepository $checkoutRepo,
        PedidoRepository $pedidoRepo,
        ClienteRepository $clienteRepo,
        LancamentoReceberRepository $lancamentoReceberRepo
    ) {
        $this->checkoutRepository = $checkoutRepo;
        $this->pedidoRepository   = $pedidoRepo;
        $this->clienteRepository  = $clienteRepo;
        $this->lancamentoReceberRepository = $lancamentoReceberRepo;
        // Set Permissions
        // $this->middleware('permission:checkout_listar', ['only' => ['index']]);
        // $this->middleware('permission:checkout_adicionar', ['only' => ['create', 'store']]);
        // $this->middleware('permission:checkout_editar', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:checkout_deletar', ['only' => ['destroy']]);
        // $this->middleware('permission:checkout_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Checkout.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Checkout";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Checkout";
        /** Filtros */
        $this->checkoutRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->checkoutRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $checkouts = $this->checkoutRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $checkouts = $this->checkoutRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $checkouts = $this->checkoutRepository->paginate();
            }
        } else {
            $checkouts = $this->checkoutRepository->paginate();
        }

        return view('checkouts.index', compact('title', 'breadcrumb', 'checkouts', 'filters'));
    }

    /**
     * Show the form for creating a new Checkout.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Checkout";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addCheckout";

        return view('checkouts.create', compact('title', 'breadcrumb'));
    }

    /**
     * Store a newly created Checkout in storage.
     *
     * @param CreateCheckoutRequest $request
     *
     * @return Response
     */
    public function store(CreateCheckoutRequest $request)
    {
        $input  = $request->all();
        $pedido  = $this->pedidoRepository->findWithoutFail($input['pedido_id']);
        $checkout = $this->checkoutRepository->findWhere([
            'pedido_id'=>$input['pedido_id']
            ])->first();

        if (empty($pedido) && $checkout->status != 0) {
            Flash::error('Pedido não encontrado ou já faturado');

            return redirect(route('checkouts.index'));
        }
        
        $args = array_merge($pedido->toArray(), ['pedido_id'=>$input['pedido_id'], 'valor'=> $pedido->valor_total]);
        $this->__load($args);

        if (empty($checkout)) {
            $checkout = $this->checkoutRepository->create($this->getCheckout());
        }
        
        Flash::success('Checkout salvo com sucesso.');

        return redirect('checkouts/'.$checkout->id.'/edit');
    }

    /**
     * Display the specified Checkout.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Checkout";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showCheckout";
        
        $checkout = $this->checkoutRepository->findWithoutFail($id);

        if (empty($checkout)) {
            Flash::error('Checkout não encontrado');

            return redirect(route('checkouts.index'));
        }

        return view('checkouts.show', compact('title', 'breadcrumb', 'checkout'));
    }

    /**
     * Show the form for editing the specified Checkout.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $checkout = $this->checkoutRepository->findWithoutFail($id);

        if (empty($checkout)) {
            Flash::error('Checkout não encontrado');

            return redirect(route('checkouts.index'));
        }

        // Titulo da página
        $title = "Checkout";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editCheckout";
        $breadcrumb->id = $checkout->id;
        $breadcrumb->titulo = $checkout->id;

        return view('checkouts.edit', compact('title', 'breadcrumb', 'checkout'));
    }

    /**
     * Update the specified Checkout in storage.
     *
     * @param  int              $id
     * @param UpdateCheckoutRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCheckoutRequest $request)
    {
        $checkout = $this->checkoutRepository->findWithoutFail($id);
        $pedido   = $this->pedidoRepository->findWithoutFail($checkout->pedido_id);
        $cliente  = $this->clienteRepository->findWithoutFail($checkout->cliente_id);

        if (empty($checkout) || empty($pedido) || empty($cliente)) {
            Flash::error('Checkout não encontrado');

            return redirect(route('checkouts.index'));
        }

        DB::beginTransaction();
        try {
            $result = array_merge($checkout->toArray(), $request->all(), $cliente->toArray());
            $this->__load($result);

            $checkout    = $this->checkoutRepository->update($this->getCheckout(), $id);
            $pedido      = $this->pedidoRepository->update($this->getPedido(), $checkout->pedido_id);
            if ($result['paymentMethod'] != 'pc') {
                $lancamentos = $this->setLancamentos();
                foreach ($lancamentos as $value) {
                    $this->lancamentoReceberRepository->create($value);
                }
                Flash::success('Checkout faturado com sucesso.');
            } else {
                $pedido->cliente()->first()->sendCheckout($checkout->id);
                Flash::success('Checkout atualizado com sucesso.');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            Flash::error('Erro ao tentar salvar Checkout');
        }

        return redirect('/pedidos/'.$checkout->pedido_id);
    }

    /**
     * Remove the specified Checkout from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        $input = $request->all();
        $ids   = $input['ids'];

        DB::beginTransaction();
        try {
            foreach ($ids as $id) {
                $this->checkoutRepository->delete($id);
            }

            DB::commit();
            Flash::success('Checkout(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Checkout(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
