<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNegocioProdutoRequest;
use App\Http\Requests\UpdateNegocioProdutoRequest;
use App\Repositories\NegocioProdutoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class NegocioProdutoController extends AppBaseController
{
    /** @var  NegocioProdutoRepository */
    private $negocioProdutoRepository;

    public function __construct(NegocioProdutoRepository $negocioProdutoRepo)
    {
        $this->negocioProdutoRepository = $negocioProdutoRepo;
    }

    /**
     * Display a listing of the NegocioProduto.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Negocio Produto";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Negocio Produto";
        /** Filtros */
        $this->negocioProdutoRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->negocioProdutoRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $negocioProdutos = $this->negocioProdutoRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $negocioProdutos = $this->negocioProdutoRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $negocioProdutos = $this->negocioProdutoRepository->paginate();
            }
        }else{
            $negocioProdutos = $this->negocioProdutoRepository->paginate();
        }

        return view('negocio_produtos.index', compact('title','breadcrumb','negocioProdutos', 'filters'));
    }

    /**
     * Show the form for creating a new NegocioProduto.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Negocio Produto";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addNegocio Produto";

        return view('negocio_produtos.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created NegocioProduto in storage.
     *
     * @param CreateNegocioProdutoRequest $request
     *
     * @return Response
     */
    public function store(CreateNegocioProdutoRequest $request)
    {
        $input = $request->all();

        $negocioProduto = $this->negocioProdutoRepository->create($input);

        Flash::success('Negocio Produto salvo com sucesso.');

        return redirect(route('negocioProdutos.index'));
    }

    /**
     * Display the specified NegocioProduto.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Negocio Produto";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showNegocio Produto";
        
        $negocioProduto = $this->negocioProdutoRepository->findWithoutFail($id);

        if (empty($negocioProduto)) {
            Flash::error('Negocio Produto não encontrado');

            return redirect(route('negocioProdutos.index'));
        }

        return view('negocio_produtos.show', compact('title','breadcrumb','negocioProduto'));
    }

    /**
     * Show the form for editing the specified NegocioProduto.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $negocioProduto = $this->negocioProdutoRepository->findWithoutFail($id);

        if (empty($negocioProduto)) {
            Flash::error('Negocio Produto não encontrado');

            return redirect(route('negocioProdutos.index'));
        }

        // Titulo da página
        $title = "Negocio Produto";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editNegocio Produto";
        $breadcrumb->id = $negocioProduto->id;
        $breadcrumb->titulo = $negocioProduto->id;

        return view('negocio_produtos.edit', compact('title','breadcrumb','negocioProduto'));
    }

    /**
     * Update the specified NegocioProduto in storage.
     *
     * @param  int              $id
     * @param UpdateNegocioProdutoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNegocioProdutoRequest $request)
    {
        $negocioProduto = $this->negocioProdutoRepository->findWithoutFail($id);

        if (empty($negocioProduto)) {
            Flash::error('Negocio Produto não encontrado');

            return redirect(route('negocioProdutos.index'));
        }

        $negocioProduto = $this->negocioProdutoRepository->update($request->all(), $id);

        Flash::success('Negocio Produto atualizado com sucesso.');

        return redirect(route('negocioProdutos.index'));
    }

    /**
     * Remove the specified NegocioProduto from storage.
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
            foreach ($ids as $id) {
                $this->negocioProdutoRepository->delete($id);
            }

            DB::commit();
            Flash::success('Negocio Produto(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Negocio Produto(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
