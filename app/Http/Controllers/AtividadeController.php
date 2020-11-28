<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAtividadeRequest;
use App\Http\Requests\UpdateAtividadeRequest;
use App\Repositories\AtividadeRepository;
use App\Repositories\NegocioRepository;
use App\Repositories\UsuarioRepository;
use App\Repositories\TipoAtividadeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;

class AtividadeController extends AppBaseController
{
    /** @var  AtividadeRepository */
    private $atividadeRepository;

    /** @var  NegocioRepository */
    private $negocioRepository;

    /** @var  UsuarioRepository */
    private $usuarioRepository;

    /** @var  TipoAtividadeRepository */
    private $tipoAtividadeRepository;

    public function __construct(
        AtividadeRepository $atividadeRepo,
        NegocioRepository $negocioRepository,
        UsuarioRepository $usuarioRepository,
        TipoAtividadeRepository $tipoAtividadeRepository
    ) {
        $this->atividadeRepository      = $atividadeRepo;
        $this->negocioRepository        = $negocioRepository;
        $this->usuarioRepository        = $usuarioRepository;
        $this->tipoAtividadeRepository  = $tipoAtividadeRepository;
    }

    /**
     * Display a listing of the Atividade.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, $idNegocio = null)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Atividades";

        if(!is_null($idNegocio )){
            $negocio = $this->negocioRepository->findWithoutFail($idNegocio);
            $title .= " - " . $negocio->titulo;
        }
        
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Atividade";
        $arrTemporario    = [];
        
        if (!empty($filtros['search']) && !empty($request['search'])) {
            $explodeSearch = explode(";", $filtros['search']);
            foreach ($explodeSearch as $index => $tmpFilter) {
                $arrTemp = explode(':', $tmpFilter);
                
                if ($arrTemp[0] == "data") {
                    $data = date('Y-m-d', strtotime(str_replace("/", "-", $arrTemp[1])));

                    array_push($arrTemporario, $arrTemp[0] . ":" . $data);
                } else {
                    array_push($arrTemporario, $tmpFilter);
                }
            }
            
            //$filtros['search'] = implode(';', $arrTemporario);
            $request['search'] = implode(';', $arrTemporario);
        }
        /** Filtros */
        $this->atividadeRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->atividadeRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $atividades = $this->atividadeRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $atividades = $this->atividadeRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $atividades = $this->atividadeRepository->paginate();
            }
        } elseif (!is_null($idNegocio)) {
            $atividades = $this->atividadeRepository->scopeQuery(function ($query) use ($idNegocio) {
                return $query->where('negocio_id', $idNegocio);
            })->paginate();
        } else {
            $atividades = $this->atividadeRepository->paginate();
        }

        $negocios  = $this->negocioRepository->all();
        $atribuidos= $this->usuarioRepository->all();
        $tipos     = $this->tipoAtividadeRepository->all();

        return view('atividades.index', compact('title', 'breadcrumb', 'tipos', 'atividades', 'filters', 'idNegocio', 'negocios', 'atribuidos'));
    }

    /**
     * Show the form for creating a new Atividade.
     *
     * @return Response
     */
    public function create($idNegocio = null)
    {
        /** Titulo da página */
        $title = "Atividades";

         if(!is_null($idNegocio )){
            $negocio = $this->negocioRepository->findWithoutFail($idNegocio);
            $title .= " - " . $negocio->titulo;
         }

        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addAtividade";

        //$negocios       = $this->negocioRepository->all();
        $negocios = $this->negocioRepository->all()->where('id', $idNegocio);
        //  $negocios = $negocio;
        $tipoAtividades = $this->tipoAtividadeRepository->all();
        $usuarios       = $this->usuarioRepository->all();

        return view('atividades.create', compact('title', 'breadcrumb', 'negocios', 'tipoAtividades', 'usuarios', 'idNegocio'));
    }

    /**
     * Store a newly created Atividade in storage.
     *
     * @param CreateAtividadeRequest $request
     *
     * @return Response
     */
    public function store(CreateAtividadeRequest $request)
    {
        $input = $request->all();

        // dd($input);

        if (!empty($input['data'])) {
            $date = DateTime::createFromFormat('d/m/Y', $input['data']);
            $usableDate = $date->format('Y-m-d');
            $input['data'] = $usableDate;
        }

        if (!empty($input['dataVencimento'])) {
            $date = DateTime::createFromFormat('d/m/Y', $input['dataVencimento']);
            $usableDate = $date->format('Y-m-d');
            $input['dataVencimento'] = $usableDate;
        }
        
        $atividade = $this->atividadeRepository->create($input);

        Flash::success('Atividade salva com sucesso.');

        return redirect(url('negocios/atividades/' . $input['negocio_id']));
    }

    /**
     * Display the specified Atividade.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Atividade";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showAtividade";
        
        $atividade = $this->atividadeRepository->findWithoutFail($id);

        if (empty($atividade)) {
            Flash::error('Atividade não encontrado');

            return redirect(route('atividades.index'));
        }

        return view('atividades.show', compact('title', 'breadcrumb', 'atividade'));
    }

    /**
     * Show the form for editing the specified Atividade.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($idNegocio = null, $id = null)
    {
        if (is_null($id)) {
            $id = $idNegocio;
        }
            
        $atividade      = $this->atividadeRepository->findWithoutFail($id);

        $idNegocio = $atividade->negocio_id;
        // $negocios       = $this->negocioRepository->all();
        $negocios = $this->negocioRepository->all()->where('id', $idNegocio);
        $tipoAtividades = $this->tipoAtividadeRepository->all();
        $usuarios       = $this->usuarioRepository->all();

        if (empty($atividade)) {
            Flash::error('Atividade não encontrado');

            return redirect(route('atividades.index'));
        }

       /** Titulo da página */
        $title = "Atividades";

        if(!is_null($idNegocio )){
            $negocio = $this->negocioRepository->findWithoutFail($idNegocio);
            $title .= " - " . $negocio->titulo;
        }

        
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editAtividade";
        $breadcrumb->id = $atividade->id;
        $breadcrumb->titulo = $atividade->id;

        
        return view('atividades.edit', compact('title', 'breadcrumb', 'atividade', 'negocios', 'tipoAtividades', 'usuarios', 'idNegocio'));
    }

    /**
     * Update the specified Atividade in storage.
     *
     * @param  int              $id
     * @param UpdateAtividadeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAtividadeRequest $request)
    {
        $atividade = $this->atividadeRepository->findWithoutFail($id);

        if (empty($atividade)) {
            Flash::error('Atividade não encontrado');

            return redirect(route('atividades.index'));
        }

        $requestAll = $request->all();

        if (!empty($requestAll['data'])) {
            $date = DateTime::createFromFormat('d/m/Y', $requestAll['data']);
            $usableDate = $date->format('Y-m-d');
            $requestAll['data'] = $usableDate;
        }

        if (!empty($requestAll['dataVencimento'])) {
            $date = DateTime::createFromFormat('d/m/Y', $requestAll['dataVencimento']);
            $usableDate = $date->format('Y-m-d');
            $requestAll['dataVencimento'] = $usableDate;
        }

        $atividade = $this->atividadeRepository->update($requestAll, $id);

        Flash::success('Atividade atualizado com sucesso.');

        return redirect(url('negocios/atividades/' . $requestAll['negocio_id']));
    }

    /**
     * Remove the specified Atividade from storage.
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
            foreach ($ids as $id) {
                $this->atividadeRepository->delete($id);
            }

            DB::commit();
            Flash::success('Atividade(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Atividade(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
