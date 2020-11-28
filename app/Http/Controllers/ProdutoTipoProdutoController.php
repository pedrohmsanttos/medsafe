<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProdutoTipoProdutoRequest;
use App\Http\Requests\UpdateProdutoTipoProdutoRequest;
use App\Repositories\ProdutoTipoProdutoRepository;
use App\Repositories\ProdutosRepository;
use App\Repositories\TipoProdutosRepository;
use App\Repositories\CategoriaProdutosRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\ProdutoTipoProduto;
use App\Models\Item;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class ProdutoTipoProdutoController extends AppBaseController
{
    /** @var  ProdutosRepository */
    private $produtoTipoProdutoRepository;
    private $produtosRepository;
    private $tipoProdutosRepository;
    private $categoriaProdutosRepository;

    public function __construct(ProdutoTipoProdutoRepository $produtoTipoProdutoRepo, ProdutosRepository $produtosRepo, TipoProdutosRepository $tipoProdutosRepo, CategoriaProdutosRepository $categoriaProdutosRepo)
    {
        $this->produtoTipoProdutoRepository = $produtoTipoProdutoRepo;
        $this->produtosRepository = $produtosRepo;
        $this->tipoProdutosRepository = $tipoProdutosRepo;
        $this->categoriaProdutosRepository = $categoriaProdutosRepo;
        // Set Permissions
        $this->middleware('permission:produto_tipo_produtos_listar', ['only' => ['index']]);
        $this->middleware('permission:produto_tipo_produtos_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:produto_tipo_produtos_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:produto_tipo_produtos_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:produto_tipo_produtos_visualizar', ['only' => ['show']]);
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
        $title = "Tabela de Preços";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "produtotipoproduto";

        $request->attributes->add(['orderBy' => 'produto_tipo_produtos.id']);
        $request->attributes->add(['sortedBy' => 'desc']);
        $this->produtoTipoProdutoRepository->pushCriteria(new RequestCriteria($request));
        //$produtoTipoProdutos = $this->produtoTipoProdutoRepository->all();

        $filters = $this->produtoTipoProdutoRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $produtoTipoProdutos = $this->produtoTipoProdutoRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $produtoTipoProdutos = $this->produtoTipoProdutoRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $produtoTipoProdutos = $this->produtoTipoProdutoRepository->paginate();
            }
        } else {
            if ($filtros!=[] && isset($filtros['search'])) {
                $sinalOperacao = explode(':', $filtros['search']);
                $campoBusca = $sinalOperacao[0];
                
                if ($campoBusca == "produto_id") {
                    $produtoTipoProdutos = $this->produtoTipoProdutoRepository->scopeQuery(function ($query) use ($filtros) {
                        $query->select('produto_tipo_produtos.produto_id', 'produto_tipo_produtos.categoria_produto_id', 'produto_tipo_produtos.tipo_produto_id', 'produto_tipo_produtos.valor', 'produtos.descricao', 'tipo_produtos.descricao', 'categoria_produtos.descricao')
                            ->join('produtos', 'produtos.id', '=', 'produto_tipo_produtos.produto_id')
                            ->join('categoria_produtos', 'categoria_produtos.id', '=', 'produto_tipo_produtos.categoria_produto_id')
                            ->join('tipo_produtos', 'tipo_produtos.id', '=', 'produto_tipo_produtos.tipo_produto_id')->where('produtos.descricao', 'like', "%".getFilter('produto_id', $filtros['search'])."%");
                        return $query; // com deletados
                    })->paginate();
                } elseif ($campoBusca == "categoria") {
                    $produtoTipoProdutos = $this->produtoTipoProdutoRepository->scopeQuery(function ($query) use ($filtros) {
                        $query->select('produto_tipo_produtos.produto_id', 'produto_tipo_produtos.categoria_produto_id', 'produto_tipo_produtos.tipo_produto_id', 'produto_tipo_produtos.valor', 'produtos.descricao', 'tipo_produtos.descricao', 'categoria_produtos.descricao')
                        ->join('produtos', 'produtos.id', '=', 'produto_tipo_produtos.produto_id')
                        ->join('categoria_produtos', 'categoria_produtos.id', '=', 'produto_tipo_produtos.categoria_produto_id')
                        ->join('tipo_produtos', 'tipo_produtos.id', '=', 'produto_tipo_produtos.tipo_produto_id')->where('categoria_produtos.descricao', 'like', "%".getFilter('categoria', $filtros['search'])."%");
                        return $query; // com deletados
                    })->paginate();
                } elseif ($campoBusca == "tipo") {
                    $produtoTipoProdutos = $this->produtoTipoProdutoRepository->scopeQuery(function ($query) use ($filtros) {
                        $query->select('produto_tipo_produtos.produto_id', 'produto_tipo_produtos.categoria_produto_id', 'produto_tipo_produtos.tipo_produto_id', 'produto_tipo_produtos.valor', 'produtos.descricao', 'tipo_produtos.descricao', 'categoria_produtos.descricao')
                        ->join('produtos', 'produtos.id', '=', 'produto_tipo_produtos.produto_id')
                        ->join('categoria_produtos', 'categoria_produtos.id', '=', 'produto_tipo_produtos.categoria_produto_id')
                        ->join('tipo_produtos', 'tipo_produtos.id', '=', 'produto_tipo_produtos.tipo_produto_id')->where('tipo_produtos.descricao', 'like', "%".getFilter('tipo', $filtros['search'])."%");
                        return $query; // com deletados
                    })->paginate();
                } else {
                    $produtoTipoProdutos = $this->produtoTipoProdutoRepository->paginate();
                }
            }
            $produtoTipoProdutos = $this->produtoTipoProdutoRepository->paginate();
        }

        return view('produto_tipo_produtos.index', compact('title', 'breadcrumb', 'produtoTipoProdutos', 'filters'));
    }

    /**
     * Show the form for creating a new Produtos.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Tabela de Preço";
        /** Breadcrumb */
        $produtoTipoProdutos = new \stdClass;
        $produtoTipoProdutos->produto_id ="";
        $produtoTipoProdutos->tipo_produto_id ="";
        $produtoTipoProdutos->categoria_produto_id ="";
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addProdutoTipoProduto";
        $produtos = $this->produtosRepository->all();
        $categorias = $this->categoriaProdutosRepository->all();
        $tipos = $this->tipoProdutosRepository->all();
        return view('produto_tipo_produtos.create', compact('title', 'breadcrumb', 'produtoTipoProdutos', 'categorias', 'tipos', 'produtos'));
        //return view('produto_tipo_produtos.create');
    }

    /**
     * Store a newly created Produtos in storage.
     *
     * @param CreateProdutoTipoProdutoRequest $request
     *
     * @return Response
     */
    public function store(CreateProdutoTipoProdutoRequest $request)
    {
        $input = $request->all();
        $input['valor'] = getRealValue($input['valor']);
    
        DB::beginTransaction();
        try {
            $produtoTipoProdutos  = $this->produtoTipoProdutoRepository->create($input);
            $input['produto_id'] = $produtoTipoProdutos->id;
            
            DB::commit();
            Flash::success('Tabela de Preço salva com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao tentar cadastrar Tabela de Preço');
        }
        return redirect(route('produtoTipoProdutos.index'));
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
        $produtoTipoProdutos = $this->produtoTipoProdutoRepository->findWithoutFail($id);
        if (empty($produtoTipoProdutos)) {
            Flash::error('Produto não encontrado');

            return redirect(route('produto_tipo_produtos.index'));
        }
        // Titulo da página
        $title = "Tabela de Preço: ". $produtoTipoProdutos->id;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showProdutoTipoProduto";
        $breadcrumb->titulo = $produtoTipoProdutos->id;
        return view('produto_tipo_produtos.show', compact('title', 'breadcrumb', 'produtoTipoProdutos'));
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
        $produtoTipoProdutos  = $this->produtoTipoProdutoRepository->findWithoutFail($id);
        if (empty($produtoTipoProdutos)) {
            Flash::error('Tabela de Preços não encontrada!');

            return redirect(route('produto_tipo_produtos.index'));
        }
        // Titulo da página
        $title = "Editar: ". $produtoTipoProdutos->id;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editProdutoTipoProduto";
        $breadcrumb->id = $produtoTipoProdutos->id;
        $breadcrumb->titulo = $produtoTipoProdutos->id;

        $produtos = $this->produtosRepository->all();
        $categorias = $this->categoriaProdutosRepository->all();
        $tipos = $this->tipoProdutosRepository->all();

        return view('produto_tipo_produtos.edit', compact('title', 'breadcrumb', 'produtoTipoProdutos', 'produtos', 'categorias', 'tipos'));
    }

    /**
     * Update the specified Produtos in storage.
     *
     * @param  int              $id
     * @param UpdateProdutoTipoProdutoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProdutoTipoProdutoRequest $request)
    {
        $produtoTipoProdutos = $this->produtoTipoProdutoRepository->findWithoutFail($id);

        $request['valor'] = getRealValue($request['valor']);
        
        //valor da parcela
        $request['valor_parcela'] = getRealValue($request['valor_parcela']);
        
        if (empty($produtoTipoProdutos)) {
            Flash::error('Tabela de Preços não enontrada.');

            return redirect(route('produto_tipo_produtos.index'));
        }

        $produtoTipoProdutos = $this->produtoTipoProdutoRepository->update($request->all(), $id);

        Flash::success('Tabela de Preços atualizada com sucesso.');

        return redirect(route('produtoTipoProdutos.index'));
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
                $tabela = ProdutoTipoProduto::find($id);
                $itens = Item::where('tabela_preco_id',$id)->get();
                if(count($itens ) == 0){
                    $this->produtoTipoProdutoRepository->delete($id);
                } else{
                    $itensProibidos .= $tabela->id.",";
                }
            }
            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('As Tabelas de preço(s) com ID: "'.$itensProibidos. '" não podem ser inativadas porque são utilizadas em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }
            DB::commit();
            Flash::success('Tabela(s) de preço(s) inativada(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Tabela(s) de preço(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
