<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProdutosRequest;
use App\Http\Requests\UpdateProdutosRequest;
use App\Repositories\ProdutosRepository;
use App\Repositories\TipoProdutosRepository;
use App\Repositories\CategoriaProdutosRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Produtos;
use App\Models\ProdutoTipoProduto;
use App\Models\MedsafeBeneficio;
use App\Models\PedidoTipoProduto;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class ProdutosController extends AppBaseController
{
    /** @var  ProdutosRepository */
    private $produtosRepository;
    private $tipoProdutosRepository;
    private $categoriaProdutosRepository;

    public function __construct(ProdutosRepository $produtosRepo, TipoProdutosRepository $tipoProdutosRepo, CategoriaProdutosRepository $categoriaProdutosRepo)
    {
        $this->produtosRepository = $produtosRepo;
        $this->tipoProdutosRepository = $tipoProdutosRepo;
        $this->categoriaProdutosRepository = $categoriaProdutosRepo;
        // Set Permissions
        $this->middleware('permission:produtos_listar', ['only' => ['index']]);
        $this->middleware('permission:produtos_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:produtos_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:produtos_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:produtos_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Produtos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Produtos/Serviços";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "produto";

        $this->produtosRepository->pushCriteria(new RequestCriteria($request));
        //$produtos = $this->produtosRepository->all();

        $filters = $this->produtosRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $produtos = $this->produtosRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $produtos = $this->produtosRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $produtos = $this->produtosRepository->paginate();
            }
        } else {
            $produtos = $this->produtosRepository->paginate();
        }

        return view('produtos.index', compact('title', 'breadcrumb', 'produtos', 'filters'));
    }

    /**
     * Show the form for creating a new Produtos.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Produto/Serviço";
        /** Breadcrumb */
        $produto = new \stdClass;
        $produto->tipo_produto_id ="";
        $produto->categoria_produto_id ="";
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addProduto";

        $categorias = $this->categoriaProdutosRepository->all();
        $tipos      = $this->tipoProdutosRepository->all();

        return view('produtos.create', compact('title', 'breadcrumb', 'categorias', 'tipos', 'produto'));
    }

    /**
     * Store a newly created Produtos in storage.
     *
     * @param CreateProdutosRequest $request
     *
     * @return Response
     */
    public function store(CreateProdutosRequest $request)
    {
        $input = $request->all();
        
        DB::beginTransaction();
        try {
            $produtos  = $this->produtosRepository->create($input);
            $input['produto_id'] = $produtos->id;
            
            DB::commit();
            Flash::success('Produto salvo com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao tentar cadastrar Produto');
        }
        return redirect(route('produtos.index'));
    }

    /**
     * Display the specified Produtos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $produtos = $this->produtosRepository->findWithoutFail($id);
        if (empty($produtos)) {
            Flash::error('Produto não encontrado');

            return redirect(route('produtos.index'));
        }
        // Titulo da página
        $title = "Produto: ". $produtos->descricao;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showProduto";
        $breadcrumb->titulo = $produtos->descricao;

        return view('produtos.show', compact('title', 'breadcrumb', 'produto'));
    }

    /**
     * Show the form for editing the specified Produtos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $produto  = $this->produtosRepository->findWithoutFail($id);
        if (empty($produto)) {
            Flash::error('Produto não encontrado!');

            return redirect(route('produtos.index'));
        }
        // Titulo da página
        $title = "Editar: ". $produto->descricao;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editProduto";
        $breadcrumb->id = $produto->id;
        $breadcrumb->titulo = $produto->descricao;

        $categorias = $this->categoriaProdutosRepository->all();
        $tipos = $this->tipoProdutosRepository->all();

        return view('produtos.edit', compact('title', 'breadcrumb', 'produto', 'categorias', 'tipos'));
    }

    /**
     * Update the specified Produtos in storage.
     *
     * @param  int              $id
     * @param UpdateProdutosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProdutosRequest $request)
    {
        $produtos = $this->produtosRepository->findWithoutFail($id);

        if (empty($produtos)) {
            Flash::error('Produtos não enontrado.');

            return redirect(route('produtos.index'));
        }

        $produtos = $this->produtosRepository->update($request->all(), $id);

        Flash::success('Produto atualizao com sucesso.');

        return redirect(route('produtos.index'));
    }

    /**
     * Remove the specified Produtos from storage.
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
            $itensProibidos = "";
            foreach ($ids as $id) {
                $produto = Produtos::find($id);
                $ProdutoTipoProdutos = ProdutoTipoProduto::where('produto_id',$id)->get();
                $medsafeBeneficio = MedsafeBeneficio::where('produto_id',$id)->get();
                $pedidoTipoProdutos = PedidoTipoProduto::where('produto_id',$id)->get();
                if(count($ProdutoTipoProdutos ) == 0 && count($medsafeBeneficio ) == 0 && count($pedidoTipoProdutos ) == 0){
                    $this->produtosRepository->delete($id);
                } else{
                    $itensProibidos .= $produto->descricao.",";
                }
            }
            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('Os Produto(s): "'.$itensProibidos. '" não podem ser inativados porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }
            
            DB::commit();
            Flash::success('Produto(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Produto(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
