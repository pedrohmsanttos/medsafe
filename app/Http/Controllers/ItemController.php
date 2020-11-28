<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Repositories\ItemRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class ItemController extends AppBaseController
{
    /** @var  ItemRepository */
    private $itemRepository;

    public function __construct(ItemRepository $itemRepo)
    {
        $this->itemRepository = $itemRepo;
        // Set Permissions
        $this->middleware('permission:item_listar', ['only' => ['index']]); 
        $this->middleware('permission:item_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:item_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:item_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:item_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Item.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Item";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Item";
        /** Filtros */
        $this->itemRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->itemRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $items = $this->itemRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $items = $this->itemRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $items = $this->itemRepository->paginate();
            }
        }else{
            $items = $this->itemRepository->paginate();
        }

        return view('items.index', compact('title','breadcrumb','items', 'filters'));
    }

    /**
     * Show the form for creating a new Item.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Item";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addItem";

        return view('items.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Item in storage.
     *
     * @param CreateItemRequest $request
     *
     * @return Response
     */
    public function store(CreateItemRequest $request)
    {
        $input = $request->all();

        $item = $this->itemRepository->create($input);

        Flash::success('Item salvo com sucesso.');

        return redirect(route('items.index'));
    }

    /**
     * Display the specified Item.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Item";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showItem";
        
        $item = $this->itemRepository->findWithoutFail($id);

        if (empty($item)) {
            Flash::error('Item não encontrado');

            return redirect(route('items.index'));
        }

        return view('items.show', compact('title','breadcrumb','item'));
    }

    /**
     * Show the form for editing the specified Item.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $item = $this->itemRepository->findWithoutFail($id);

        if (empty($item)) {
            Flash::error('Item não encontrado');

            return redirect(route('items.index'));
        }

        // Titulo da página
        $title = "Item";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editItem";
        $breadcrumb->id = $item->id;
        $breadcrumb->titulo = $item->id;

        return view('items.edit', compact('title','breadcrumb','item'));
    }

    /**
     * Update the specified Item in storage.
     *
     * @param  int              $id
     * @param UpdateItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemRequest $request)
    {
        $item = $this->itemRepository->findWithoutFail($id);

        if (empty($item)) {
            Flash::error('Item não encontrado');

            return redirect(route('items.index'));
        }

        $item = $this->itemRepository->update($request->all(), $id);

        Flash::success('Item atualizado com sucesso.');

        return redirect(route('items.index'));
    }

    /**
     * Remove the specified Item from storage.
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
                $this->itemRepository->delete($id);
            }

            DB::commit();
            Flash::success('Item(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Item(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
