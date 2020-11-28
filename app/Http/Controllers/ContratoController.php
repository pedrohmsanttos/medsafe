<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContratoRequest;
use App\Http\Requests\UpdateContratoRequest;
use App\Repositories\ContratoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class ContratoController extends AppBaseController
{
    /** @var  ContratoRepository */
    private $contratoRepository;

    public function __construct(ContratoRepository $contratoRepo)
    {
        $this->contratoRepository = $contratoRepo;
        // Set Permissions
        $this->middleware('permission:contratos_produtos_listar', ['only' => ['index']]); 
        $this->middleware('permission:contratos_produtos_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:contratos_produtos_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:contratos_produtos_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:contratos_produtos_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Contrato.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
       
        $filtros = $request->all(); 
        $this->contratoRepository->pushCriteria(new RequestCriteria($request));
        
        /** Titulo da página */
        $title = "Contratos";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "contratos";

        $filters = $this->contratoRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $contratos = $this->contratoRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $contratos = $this->contratoRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $contratos = $this->contratoRepository->paginate();
            }
        }else{
            $contratos = $this->contratoRepository->paginate();
        }

        // dd($breadcrumb);


        return view('contratos.index', compact('title','breadcrumb','contratos', 'filters'));
    
    }

    /**
     * Show the form for creating a new Contrato.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Contrato";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addContrato";
        return view('contratos.create', compact('title','breadcrumb'));

    }

    /**
     * Store a newly created Contrato in storage.
     *
     * @param CreateContratoRequest $request
     *
     * @return Response 
     */
    public function store(CreateContratoRequest $request)
    {
        $input = $request->all();
        
        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
            
            $nameFile = "contrato_".time().'.'.request()->arquivo->getClientOriginalExtension();
    
            // Faz o upload:
            $upload = $request->arquivo->storeAs('contratos', $nameFile);
            $input['arquivo'] = $upload;
    
            // Verifica se NÃO deu certo o upload (Redireciona de volta)
            if ( !$upload )
                return redirect()->back()->with('error', 'Falha ao fazer upload')->withInput();
    
        }

        $contrato = $this->contratoRepository->create($input);

        Flash::success('Contrato salvo com sucesso.');

        return redirect(route('contratos.index'));
    }

    /**
     * Display the specified Contrato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contrato = $this->contratoRepository->findWithoutFail($id);

        if (empty($contrato)) {
            Flash::error('Contrato not found');

            return redirect(route('contratos.index'));
        }

        return view('contratos.show')->with('contrato', $contrato);
    }

    /**
     * Show the form for editing the specified Contrato.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contrato  = $this->contratoRepository->findWithoutFail($id);
       
        // echo $contrato->arquivo;
        $url = Storage::url($contrato->arquivo); 
        
        if (empty($contrato)) {
            Flash::error('Contrato não encontrado!');

            return redirect(route('contratos.index'));
        }

        // Titulo da página
        $title = "Editar: ". $contrato->titulo;
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editContrato";
        $breadcrumb->id = $contrato->id;
        $breadcrumb->titulo = $contrato->titulo;

        return view('contratos.edit', compact('title','breadcrumb','contrato'));
    }

    /**
     * Update the specified Contrato in storage.
     *
     * @param  int              $id
     * @param UpdateContratoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContratoRequest $request)
    {
        $contrato = $this->contratoRepository->findWithoutFail($id);

        if (empty($contrato)) {
            Flash::error('Contrato não encontrado');

            return redirect(route('contratos.index'));
        }
        $requestAll = $request->all();
        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
        
            $nameFile = "contrato_".time().'.'.request()->arquivo->getClientOriginalExtension();
            
            // Faz o upload:
            $upload = $request->arquivo->storeAs('contratos', $nameFile);
            
            $requestAll = $request->all();
            $requestAll['arquivo'] = $upload;

            // Verifica se NÃO deu certo o upload (Redireciona de volta)
            if ( !$upload )
                return redirect()->back()->with('error', 'Falha ao fazer upload')->withInput();
     
        }
        
        $contrato = $this->contratoRepository->update($requestAll, $id);
        Flash::success('Contrato atualizado com sucesso.');

        return redirect(route('contratos.index'));
    }

    /**
     * Remove the specified Contrato from storage.
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
                $this->contratoRepository->delete($id);
            }

            DB::commit();
            Flash::success('Contrato(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Seu(s) Contrato(s) não foi(ram) inativado(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
