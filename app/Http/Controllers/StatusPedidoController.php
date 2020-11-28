<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStatusPedidoRequest;
use App\Http\Requests\UpdateStatusPedidoRequest;
use App\Repositories\StatusPedidoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\StatusPedido;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class StatusPedidoController extends AppBaseController
{
    /** @var  StatusPedidoRepository */
    private $statusPedidoRepository;

    public function __construct(StatusPedidoRepository $statusPedidoRepo)
    {
        $this->statusPedidoRepository = $statusPedidoRepo;
        // Set Permissions
        $this->middleware('permission:status_pedidos_listar', ['only' => ['index']]); 
        $this->middleware('permission:status_pedidos_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:status_pedidos_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:status_pedidos_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:status_pedidos_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the StatusPedido.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Status dos Pedidos";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "statusPedidos";
        
        $this->statusPedidoRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->statusPedidoRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $statusPedidos = $this->statusPedidoRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $statusPedidos = $this->statusPedidoRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $statusPedidos = $this->statusPedidoRepository->paginate();
            }
        }else{
            $statusPedidos = $this->statusPedidoRepository->paginate();
        }

        return view('status_pedidos.index', compact('title','breadcrumb','statusPedidos', 'filters'));
    }

    /**
     * Show the form for creating a new StatusPedido.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Status de Pedido";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addStatusPedido";

        return view('status_pedidos.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created StatusPedido in storage.
     *
     * @param CreateStatusPedidoRequest $request
     *
     * @return Response
     */
    public function store(CreateStatusPedidoRequest $request)
    {
        $input = $request->all();
        
        DB::beginTransaction();
        try{
            $statusPedido  = $this->statusPedidoRepository->create($input);

            DB::commit();
            Flash::success('Status Pedido salvo com sucesso.');
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao tentar cadastrar Status Pedido');
        }

        return redirect(route('statusPedidos.index'));
    }

    /**
     * Display the specified StatusPedido.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $statusPedido = $this->statusPedidoRepository->findWithoutFail($id);

        if (empty($statusPedido)) {
            Flash::error('Status Pedido not found');

            return redirect(route('statusPedidos.index'));
        }

        return view('status_pedidos.show')->with('statusPedido', $statusPedido);
    }

    /**
     * Show the form for editing the specified StatusPedido.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $statusPedido  = $this->statusPedidoRepository->findWithoutFail($id);
        
        if (empty($statusPedido)) {
            Flash::error('Status Pedido não encontrado!');

            return redirect(route('statusPedidos.index'));
        }

        // Titulo da página
        $title = "Editar: ". $statusPedido->status_pedido;
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editStatusPedido";
        $breadcrumb->id = $statusPedido->id;
        $breadcrumb->titulo = $statusPedido->status_pedido;

        return view('status_pedidos.edit', compact('title','breadcrumb','statusPedido'));
    }

    /**
     * Update the specified StatusPedido in storage.
     *
     * @param  int              $id
     * @param UpdateStatusPedidoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStatusPedidoRequest $request)
    {
        $statusPedido = $this->statusPedidoRepository->findWithoutFail($id);

        if(empty($statusPedido)){
            Flash::error('Status Pedido não encontrado!');

            return redirect(route('statusPedidos.index'));
        }

        $statusPedido = $this->statusPedidoRepository->update($request->all(), $id);

        Flash::success('Status Pedido atualizado com sucesso.');

        return redirect(route('statusPedidos.index'));
    }

    /**
     * Remove the specified StatusPedido from storage.
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
        try{
            $itensProibidos = "";
            foreach ($ids as $id) {
                $statusPedido = StatusPedido::find($id);
                $pedidos = Pedido::where('status_pedido_id',$id)->get();
                if( count( $pedidos ) == 0){
                    $this->statusPedidoRepository->delete($id);
                } else{
                    $itensProibidos .= $statusPedido->status_pedido.",";
                }
            }
            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('Os status(s): "'.$itensProibidos. '" não podem ser inativados porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }

            DB::commit();
            Flash::success('Status Pedido(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Status Pedido(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
