<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFornecedoresRequest;
use App\Http\Requests\UpdateFornecedoresRequest;
use App\Repositories\FornecedorRepository;
use App\Repositories\EnderecoRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Fornecedor;
use App\Models\LancamentoPagar;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class FornecedorController extends AppBaseController
{
    /** @var  FornecedoresRepository */
    private $fornecedorRepository;
    /** @var  EnderecoRepository */
    private $enderecoRepository;

    public function __construct(FornecedorRepository $fornecedorRepo,
        EnderecoRepository $enderecoRepo)
    {
        $this->fornecedorRepository = $fornecedorRepo;
        $this->enderecoRepository = $enderecoRepo;
        // Set Permissions
        $this->middleware('permission:fornecedores_listar', ['only' => ['index']]); 
        $this->middleware('permission:fornecedores_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:fornecedores_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:fornecedores_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:fornecedores_visualizar', ['only' => ['show']]);  
    }

    /**
     * Display a listing of the Fornecedores.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 
        
        /** Titulo da página */
        $title = "Fornecedores";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "fornecedores";

        $this->fornecedorRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->fornecedorRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $fornecedores = $this->fornecedorRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $fornecedores = $this->fornecedorRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $fornecedores = $this->fornecedorRepository->paginate();
            }
        }else{
            $fornecedores = $this->fornecedorRepository->paginate();
        }
        
        return view('fornecedores.index', compact('title','breadcrumb','fornecedores', 'filters'));
    }

    /**
     * Show the form for creating a new Fornecedores.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Fornecedor";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addFornecedor";

        return view('fornecedores.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Fornecedores in storage.
     *
     * @param CreateFornecedoresRequest $request
     *
     * @return Response
     */
    public function store(CreateFornecedoresRequest $request)
    {
        $input = $request->all();
        
        DB::beginTransaction();
        try{
            $fornecedor  = $this->fornecedorRepository->create($input);
            $input['fornecedor_id'] = $fornecedor->id;
            
            $endereco = $this->enderecoRepository->create($input);

            DB::commit();
            Flash::success('Fornecedor salvo com sucesso.');
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao tentar cadastrar Fornecedor');
        }

        return redirect(route('fornecedores.index'));
    }

    /**
     * Display the specified Fornecedores.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $fornecedor = $this->fornecedoresRepository->findWithoutFail($id);

        if (empty($fornecedor)) {
            Flash::error('Fornecedor não encontrado');

            return redirect(route('fornecedores.index'));
        }

        // Titulo da página 
        $title = "Fornecedor: ". $fornecedor->razaoSocial;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showFornecedor";
        $breadcrumb->titulo = $fornecedor->razaoSocial;

        return view('fornecedores.show')->with('fornecedores', $fornecedores);
    }

    /**
     * Show the form for editing the specified Fornecedores.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $fornecedor = $this->fornecedorRepository->findWithoutFail($id);
       

        if (empty($fornecedor)) {
            Flash::error('Fornecedores não encontrado!');

            return redirect(route('fornecedores.index'));
        }

        $endereco = $fornecedor->endereco()->first();

        // Titulo da página
        $title = "Editar: ". $fornecedor->razaoSocial;
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editFornecedor";
        $breadcrumb->id = $fornecedor->id;
        $breadcrumb->titulo = $fornecedor->razaoSocial;

        return view('fornecedores.edit', compact('title','breadcrumb','fornecedor', 'endereco'));
    }

    /**
     * Update the specified Fornecedores in storage.
     *
     * @param  int              $id
     * @param UpdateFornecedoresRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFornecedoresRequest $request)
    {
        $fornecedores = $this->fornecedorRepository->findWithoutFail($id);
        $fornecedorEndereco = $fornecedores->endereco()->first(); 

       

        if (empty($fornecedores) || empty($fornecedorEndereco)) {
            Flash::error('Fornecedor não encontrado!');

            return redirect(url('/fornecedores'));
        }

       

        $fornecedores = $this->fornecedorRepository->update($request->all(), $id);

      
        $endereco = $this->enderecoRepository->update($request->all(), $fornecedorEndereco->id);
        
    
        Flash::success('Fornecedor atualizado com sucesso!');

        return redirect(url('/fornecedores'));
    }

    /**
     * Remove the specified Fornecedores from storage.
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
                $fornecedor = Fornecedor::find($id);
                $lancamentoPagars = LancamentoPagar::where('fornecedor_id',$id)->get();
;                if(count($lancamentoPagars ) == 0){
                    $this->fornecedorRepository->delete($id);
                } else{
                    $itensProibidos .= $fornecedor->nomeFantasia.",";
                }
            }
            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('Os Fornecedore(s): "'.$itensProibidos. '" não podem ser inativados porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }

            DB::commit();
            Flash::success('Fornecedor(es) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Fornecedor(es)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
