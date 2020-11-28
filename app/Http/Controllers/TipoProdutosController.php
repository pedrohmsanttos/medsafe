<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTipoProdutosRequest;
use App\Http\Requests\UpdateTipoProdutosRequest;
use App\Repositories\TipoProdutosRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\TipoProdutos;
use App\Models\Produtos;
use App\Models\ProdutoTipoProduto;
use App\Models\PedidoTipoProduto;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class TipoProdutosController extends AppBaseController
{
    /** @var  TipoProdutosRepository */
    private $tipoProdutosRepository;

    public function __construct(TipoProdutosRepository $tipoProdutosRepo)
    {
        $this->tipoProdutosRepository = $tipoProdutosRepo;
        // Set Permissions
        $this->middleware('permission:tipo_produtos_listar', ['only' => ['index']]);
        $this->middleware('permission:tipo_produtos_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:tipo_produtos_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tipo_produtos_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:tipo_produtos_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the TipoProdutos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Tipos de Produtos/Serviços";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "tipoProduto";

        $this->tipoProdutosRepository->pushCriteria(new RequestCriteria($request));
        //$tipoProdutos = $this->tipoProdutosRepository->all();

        $filters = $this->tipoProdutosRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $tipoProdutos = $this->tipoProdutosRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $tipoProdutos = $this->tipoProdutosRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $tipoProdutos = $this->tipoProdutosRepository->paginate();
            }
        } else {
            $tipoProdutos = $this->tipoProdutosRepository->paginate();
        }

        return view('tipo_produtos.index', compact('title', 'breadcrumb', 'tipoProdutos', 'filters'));


        //return view('tipo_produtos.index')->with('tipoProdutos', $tipoProdutos);
    }

    /**
     * Show the form for creating a new TipoProdutos.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Tipo de Produtos/Serviços";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addTipoProduto";

        return view('tipo_produtos.create', compact('title', 'breadcrumb'));
        //return view('tipo_produtos.create');
    }

    /**
     * Store a newly created TipoProdutos in storage.
     *
     * @param CreateTipoProdutosRequest $request
     *
     * @return Response
     */
    public function store(CreateTipoProdutosRequest $request)
    {
        $input = $request->all();
        
        DB::beginTransaction();
        try {
            $tipoProdutos  = $this->tipoProdutosRepository->create($input);
            $input['tipo_produto_id'] = $tipoProdutos->id;
            
            DB::commit();
            Flash::success('Tipo de Produto salvo com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao tentar cadastrar Tipo de Produto');
        }
        return redirect(route('tipoProdutos.index'));
    }

    /**
     * Display the specified TipoProdutos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tipoProdutos = $this->tipoProdutosRepository->findWithoutFail($id);
        if (empty($tipoProdutos)) {
            Flash::error('Tipo de Produto não encontrada');

            return redirect(route('tipoProdutos.index'));
        }
        // Titulo da página
        $title = "Tipo de Produto: ". $tipoProdutos->descricao;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showTipoProduto";
        $breadcrumb->titulo = $tipoProdutos->descricao;
        return view('tipoProdutos.show', compact('title', 'breadcrumb', 'tipoProduto'));
    }

    /**
     * Show the form for editing the specified TipoProdutos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tipoProdutos  = $this->tipoProdutosRepository->findWithoutFail($id);
        if (empty($tipoProdutos)) {
            Flash::error('Tipo de Produto não encontrado!');

            return redirect(route('tipoProdutos.index'));
        }
        // Titulo da página
        $title = "Editar: ". $tipoProdutos->descricao;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editTipoProduto";
        $breadcrumb->id = $tipoProdutos->id;
        $breadcrumb->titulo = $tipoProdutos->descricao;
        return view('tipo_produtos.edit', compact('title', 'breadcrumb', 'tipoProdutos'));
    }

    /**
     * Update the specified TipoProdutos in storage.
     *
     * @param  int              $id
     * @param UpdateTipoProdutosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTipoProdutosRequest $request)
    {
        $tipoProdutos = $this->tipoProdutosRepository->findWithoutFail($id);

        if (empty($tipoProdutos)) {
            Flash::error('Tipo de Produtos not found');

            return redirect(route('tipoProdutos.index'));
        }

        $tipoProdutos = $this->tipoProdutosRepository->update($request->all(), $id);

        Flash::success('Tipo de Produtos atualizado com sucesso.');

        return redirect(route('tipoProdutos.index'));
    }

    /**
     * Remove the specified TipoProdutos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        /*
        $tipoProdutos = $this->tipoProdutosRepository->findWithoutFail($id);

        if (empty($tipoProdutos)) {
            Flash::error('Tipo Produtos not found');

            return redirect(route('tipoProdutos.index'));
        }

        $this->tipoProdutosRepository->delete($id);

        Flash::success('Tipo Produtos deleted successfully.');

        return redirect(route('tipoProdutos.index'));
        */

        $input = $request->all();
        $ids   = $input['ids'];

        DB::beginTransaction();
        try {
            $itensProibidos = "";
            foreach ($ids as $id) {
                $tipoProduto = TipoProdutos::find($id);
                $ProdutoTipoProdutos = ProdutoTipoProduto::where('tipo_produto_id',$id)->get();
                $pedidoTipoProdutos = PedidoTipoProduto::where('tipo_produto_id',$id)->get();
                if(count($ProdutoTipoProdutos ) == 0 && count($pedidoTipoProdutos ) == 0){
                    $this->tipoProdutosRepository->delete($id);
                } else{
                    $itensProibidos .= $tipoProduto->descricao.",";
                }
            }

            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('Os Tipos de Produtos/Serviço(s): "'.$itensProibidos. '" não podem ser inativados porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }

            DB::commit();
            Flash::success('Tipo(s) de Produto inativada(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Tipo(s) de Produto!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
