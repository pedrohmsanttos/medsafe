<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoriaProdutosRequest;
use App\Http\Requests\UpdateCategoriaProdutosRequest;
use App\Repositories\CategoriaProdutosRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\CategoriaProdutos;
use App\Models\ProdutoTipoProduto;
use App\Models\PedidoTipoProduto;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class CategoriaProdutosController extends AppBaseController
{
    /** @var  CategoriaProdutosRepository */
    private $categoriaProdutosRepository;

    public function __construct(CategoriaProdutosRepository $categoriaProdutosRepo)
    {
        $this->categoriaProdutosRepository = $categoriaProdutosRepo;
        // Set Permissions
        $this->middleware('permission:categoria_produtos_listar', ['only' => ['index']]);
        $this->middleware('permission:categoria_produtos_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:categoria_produtos_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:categoria_produtos_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:categoria_produtos_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the CategoriaProdutos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Categoria de Produtos/Serviços";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "categoriaProduto";

        $this->categoriaProdutosRepository->pushCriteria(new RequestCriteria($request));
        //$categoriaProdutos = $this->categoriaProdutosRepository->all();

        $filters = $this->categoriaProdutosRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $categoriaProdutos = $this->categoriaProdutosRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $categoriaProdutos = $this->categoriaProdutosRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $categoriaProdutos = $this->categoriaProdutosRepository->paginate();
            }
        } else {
            $categoriaProdutos = $this->categoriaProdutosRepository->paginate();
        }

        return view('categoria_produtos.index', compact('title', 'breadcrumb', 'categoriaProdutos', 'filters'));


        //return view('categoria_produtos.index')->with('categoriaProdutos', $categoriaProdutos);
    }

    /**
     * Show the form for creating a new CategoriaProdutos.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Categoria de Produto/Serviço";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addCategoriaProduto";

        return view('categoria_produtos.create', compact('title', 'breadcrumb'));
        //return view('categoria_produtos.create');
    }

    /**
     * Store a newly created CategoriaProdutos in storage.
     *
     * @param CreateCategoriaProdutosRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoriaProdutosRequest $request)
    {
        $input = $request->all();
        
        DB::beginTransaction();
        try {
            $categoriaProdutos  = $this->categoriaProdutosRepository->create($input);
            $input['categoria_produto_id'] = $categoriaProdutos->id;
            
            DB::commit();
            Flash::success('Categoria de Produto salvo com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao tentar cadastrar Categoria de Produto');
        }
        return redirect(route('categoriaProdutos.index'));
    }

    /**
     * Display the specified CategoriaProdutos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $categoriaProdutos = $this->categoriaProdutosRepository->findWithoutFail($id);
        if (empty($categoriaProdutos)) {
            Flash::error('Categoria de Produto não encontrada');

            return redirect(route('categoriaProdutos.index'));
        }
        // Titulo da página
        $title = "Categoria de Produto: ". $categoriaProdutos->descricao;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showCategoriaProduto";
        $breadcrumb->titulo = $categoriaProdutos->descricao;
        return view('categoriaProdutos.show', compact('title', 'breadcrumb', 'categoriaProduto'));
    }

    /**
     * Show the form for editing the specified CategoriaProdutos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoriaProdutos  = $this->categoriaProdutosRepository->findWithoutFail($id);
        if (empty($categoriaProdutos)) {
            Flash::error('Categoria de Produto não encontrado!');

            return redirect(route('categoriaProdutos.index'));
        }
        // Titulo da página
        $title = "Editar: ". $categoriaProdutos->descricao;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editCategoriaProduto";
        $breadcrumb->id = $categoriaProdutos->id;
        $breadcrumb->titulo = $categoriaProdutos->descricao;
        return view('categoria_produtos.edit', compact('title', 'breadcrumb', 'categoriaProdutos'));
    }

    /**
     * Update the specified CategoriaProdutos in storage.
     *
     * @param  int              $id
     * @param UpdateCategoriaProdutosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoriaProdutosRequest $request)
    {
        $categoriaProdutos = $this->categoriaProdutosRepository->findWithoutFail($id);

        if (empty($categoriaProdutos)) {
            Flash::error('Categoria de Produtos not found');

            return redirect(route('categoriaProdutos.index'));
        }

        $categoriaProdutos = $this->categoriaProdutosRepository->update($request->all(), $id);

        Flash::success('Categoria de Produtos atualizada com sucesso.');

        return redirect(route('categoriaProdutos.index'));
    }

    /**
     * Remove the specified CategoriaProdutos from storage.
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
                $categoriaProduto = CategoriaProdutos::find($id);
                $ProdutoTipoProdutos = ProdutoTipoProduto::where('categoria_produto_id',$id)->get();
                $pedidoTipoProdutos = PedidoTipoProduto::where('categoria_produto_id',$id)->get();
                if(count($ProdutoTipoProdutos ) == 0 && count($pedidoTipoProdutos ) == 0){
                    $this->categoriaProdutosRepository->delete($id);
                } else{
                    $itensProibidos .= $categoriaProduto->descricao.",";
                }
            }
            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('As Categorias de Produtos/Serviços: "'.$itensProibidos. '" não podem ser inativadas porque são utilizadas em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }
            DB::commit();
            Flash::success('Categoria(s) de Produto inativada(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Categoria(s) de Produto!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
