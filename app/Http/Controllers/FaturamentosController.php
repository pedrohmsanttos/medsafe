<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFaturamentosRequest;
use App\Http\Requests\UpdateFaturamentosRequest;
use App\Repositories\FaturamentosRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Faturamentos;
use App\Models\Organizacao;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class FaturamentosController extends AppBaseController
{
    /** @var  FaturamentosRepository */
    private $faturamentosRepository;

    public function __construct(FaturamentosRepository $faturamentosRepo)
    {
        $this->faturamentosRepository = $faturamentosRepo;
        // Set Permissions
        $this->middleware('permission:faixa_faturamentos_listar', ['only' => ['index']]); 
        $this->middleware('permission:faixa_faturamentos_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:faixa_faturamentos_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:faixa_faturamentos_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:faixa_faturamentos_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Faturamentos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Faturamentos";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "faturamento";

        $this->faturamentosRepository->pushCriteria(new RequestCriteria($request));
        //$faturamentos = $this->faturamentosRepository->all();

        $filters = $this->faturamentosRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $faturamentos = $this->faturamentosRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $faturamentos = $this->faturamentosRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $faturamentos = $this->faturamentosRepository->paginate();
            }
        }else{
            $faturamentos = $this->faturamentosRepository->paginate();
        }

        return view('faturamentos.index', compact('title','breadcrumb','faturamentos', 'filters'));


        //return view('faturamentos.index')->with('faturamentos', $faturamentos);
    }

    /**
     * Show the form for creating a new Faturamentos.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Faturamento";
        /** Breadcrumb */
        $faturamento = new \stdClass;
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addFaturamento";
        return view('faturamentos.create', compact('title','breadcrumb','faturamento'));
        //return view('faturamentos.create');

    }

    /**
     * Store a newly created Faturamentos in storage.
     *
     * @param CreateFaturamentosRequest $request
     *
     * @return Response
     */
    public function store(CreateFaturamentosRequest $request)
    {
        /*
        $input = $request->all();
        $faturamentos = $this->faturamentosRepository->create($input);
        Flash::success(' Faturamentos saved successfully.');
        return redirect(route('faturamentos.index'));
        */
        $input = $request->all();
        
        DB::beginTransaction();
        try{
            $faturamentos  = $this->faturamentosRepository->create($input);
            $input['faturamento_id'] = $faturamentos->id;
            
            DB::commit();
            Flash::success('Faturamento salvo com sucesso.');
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao tentar cadastrar Faturamento');
        }
        return redirect(route('faturamentos.index'));


    }

    /**
     * Display the specified Faturamentos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /*
        $faturamentos = $this->faturamentosRepository->findWithoutFail($id);
        if (empty($faturamentos)) {
            Flash::error(' Faturamentos not found');

            return redirect(route('faturamentos.index'));
        }
        return view('faturamentos.show')->with('faturamentos', $faturamentos);
        */

        $faturamentos = $this->faturamentosRepository->findWithoutFail($id);
        if (empty($faturamentos)) {
            Flash::error('Faturamento não encontrado');

            return redirect(route('faturamentos.index'));
        }
        // Titulo da página
        $title = "Faturamento: ". $faturamentos->descricao;
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showFaturamento";
        $breadcrumb->titulo = $faturamentos->descricao;  
        return view('faturamentos.show', compact('title','breadcrumb','faturamento'));

    }

    /**
     * Show the form for editing the specified Faturamentos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        
        /*
        $faturamentos = $this->faturamentosRepository->findWithoutFail($id);
        if (empty($faturamentos)) {
            Flash::error(' Faturamentos not found');

            return redirect(route('faturamentos.index'));
        }
        return view('faturamentos.edit')->with('faturamentos', $faturamentos);
        */

        $faturamentos  = $this->faturamentosRepository->findWithoutFail($id);
        if (empty($faturamentos)) {
            Flash::error('Faturamento não encontrado!');

            return redirect(route('faturamentos.index'));
        }
        // Titulo da página
        $title = "Editar: ". $faturamentos->descricao;
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editFaturamento";
        $breadcrumb->id = $faturamentos->id;
        $breadcrumb->titulo = $faturamentos->descricao;


        return view('faturamentos.edit', compact('title','breadcrumb','faturamentos'));
        
    }

    /**
     * Update the specified Faturamentos in storage.
     *
     * @param  int              $id
     * @param UpdateFaturamentosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFaturamentosRequest $request)
    {
        $faturamentos = $this->faturamentosRepository->findWithoutFail($id);

        if (empty($faturamentos)) {
            Flash::error('Faturamentos não enontrado.');

            return redirect(route('faturamentos.index'));
        }

        $faturamentos = $this->faturamentosRepository->update($request->all(), $id);

        Flash::success('Faturamento atualizao com sucesso.');

        return redirect(route('faturamentos.index'));
    }

    /**
     * Remove the specified Faturamentos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        /*
        $faturamentos = $this->faturamentosRepository->findWithoutFail($id);

        if (empty($faturamentos)) {
            Flash::error(' Faturamentos not found');

            return redirect(route('faturamentos.index'));
        }

        $this->faturamentosRepository->delete($id);

        Flash::success(' Faturamentos deleted successfully.');

        return redirect(route('faturamentos.index'));
        */

        $input = $request->all();
        $ids   = $input['ids'];

        DB::beginTransaction();
        try{

            $itensProibidos = "";
            foreach ($ids as $id) {
                $faturamento = Faturamentos::find($id);
                $organizacoes = Organizacao::where('faturamento_id',$id)->get();
                if(count($organizacoes ) == 0 ){
                    $this->faturamentosRepository->delete($id);
                } else{
                    $itensProibidos .= $faturamento->descricao.",";
                }
            }

            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('Os Faturamento(s): "'.$itensProibidos. '" não podem ser inativado(s) porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }

            DB::commit();
            Flash::success('Faturamento(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Faturamento(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }

    }
}
