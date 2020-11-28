<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMotivoPerdaNegocioRequest;
use App\Http\Requests\UpdateMotivoPerdaNegocioRequest;
use App\Repositories\MotivoPerdaNegocioRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\MotivoPerdaNegocio;
use App\Models\Negocio;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class MotivoPerdaNegocioController extends AppBaseController
{
    /** @var  MotivoPerdaNegocioRepository */
    private $motivoPerdaNegocioRepository;

    public function __construct(MotivoPerdaNegocioRepository $formaDePagamentoRepo)
    {
        $this->motivoPerdaNegocioRepository = $formaDePagamentoRepo;
        // Set Permissions
        $this->middleware('permission:perda_negocio_listar', ['only' => ['index']]); 
        $this->middleware('permission:perda_negocio_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:perda_negocio_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:perda_negocio_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:perda_negocio_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the MotivoPerdaNegocio.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 
        /** Titulo da página */
        $title = "Motivos de Perda de Negócio";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "motivoPerdaNegocio";


        
        $this->motivoPerdaNegocioRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->motivoPerdaNegocioRepository->filter($filtros);
       
        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $motivoPerdaNegocios = $this->motivoPerdaNegocioRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $motivoPerdaNegocios = $this->motivoPerdaNegocioRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $motivoPerdaNegocios = $this->motivoPerdaNegocioRepository->paginate();
            }
        }else{
            $motivoPerdaNegocios = $this->motivoPerdaNegocioRepository->paginate();
           
            
        }

        return view('motivo_perda_negocios.index', compact('title','breadcrumb','motivoPerdaNegocios', 'filters'));
    }

    /**
     * Show the form for creating a new MotivoPerdaNegocio.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Motivo de Perda de Negocio";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addMotivoPerdaNegocio";
        return view('motivo_perda_negocios.create', compact('title','breadcrumb'));

    }

    /**
     * Store a newly created MotivoPerdaNegocio in storage.
     *
     * @param CreateMotivoPerdaNegocioRequest $request
     *
     * @return Response
     */
    public function store(CreateMotivoPerdaNegocioRequest $request)
    {
        $input = $request->all();

        $motivoPerdaNegocio = $this->motivoPerdaNegocioRepository->create($input);

        Flash::success('Motivo de Perda de Negocio salvo com sucesso.');

        return redirect(route('motivoPerdaNegocios.index'));
    }

    /**
     * Display the specified MotivoPerdaNegocio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $motivoPerdaNegocio = $this->motivoPerdaNegocioRepository->findWithoutFail($id);

        if (empty($motivoPerdaNegocio)) {
            Flash::error('Motivo de Perda de Negocio não encontrado!');

            return redirect(route('motivoPerdaNegocios.index'));
        }

        return view('motivo_perda_negocios.show')->with('motivoPerdaNegocio', $motivoPerdaNegocio);
    }

    /**
     * Show the form for editing the specified MotivoPerdaNegocio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        
        $motivoPerdaNegocio  = $this->motivoPerdaNegocioRepository->findWithoutFail($id);
        
        if (empty($motivoPerdaNegocio)) {
            Flash::error('Motivo de Perda de Negocio não encontrado!');

            return redirect(route('motivoPerdaNegocios.index'));
        }

        // Titulo da página
        $title = "Editar: ". $motivoPerdaNegocio->titulo;
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editMotivoPerdaNegocio";
        $breadcrumb->id = $motivoPerdaNegocio->id;
        $breadcrumb->titulo = $motivoPerdaNegocio->descricao;

        return view('motivo_perda_negocios.edit', compact('title','breadcrumb','motivoPerdaNegocio'));

    }

    /**
     * Update the specified MotivoPerdaNegocio in storage.
     *
     * @param  int              $id
     * @param UpdateMotivoPerdaNegocioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMotivoPerdaNegocioRequest $request)
    {
        $motivoPerdaNegocio = $this->motivoPerdaNegocioRepository->findWithoutFail($id);

        if (empty($motivoPerdaNegocio)) {
            Flash::error('Motivo de Perda de Negocio não encontrado!');

            return redirect(route('motivoPerdaNegocios.index'));
        }

        $motivoPerdaNegocio = $this->motivoPerdaNegocioRepository->update($request->all(), $id);

        Flash::success('Motivo de Perda de Negocio atualizado com sucesso.');

        return redirect(route('motivoPerdaNegocios.index'));
    }

    /**
     * Remove the specified MotivoPerdaNegocio from storage.
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
                $motivo = MotivoPerdaNegocio::find($id);
                $negocios = Negocio::where('motivo_perda_negocio_id',$id)->get();
                if(count($negocios ) == 0 ){
                    $this->motivoPerdaNegocioRepository->delete($id);
                } else{
                    $itensProibidos .= $motivo->descricao.",";
                }
            }
            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('Os Motivo(s): "'.$itensProibidos. '" não podem ser inativado(s) porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }

            DB::commit();
            Flash::success('Motivos de Perda de Negócio(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Motivos de Perda de Negócio!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }



    }
}
