<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCorretorAPIRequest;
use App\Http\Requests\API\UpdateCorretorAPIRequest;
use App\Models\Corretor;
use App\Models\User;
use App\Models\Role;
use App\Repositories\CorretorRepository;
use App\Repositories\CorretoraRepository;
use App\Repositories\EnderecoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

/**
 * Class CorretorController
 * @package App\Http\Controllers\API
 */

class CorretorAPIController extends AppBaseController
{
    /** @var  CorretorRepository */
    private $corretorRepository;

    /** @var  CorretoraRepository */
    private $corretoraRepository;

    /** @var  EnderecoRepository */
    private $enderecoRepository;

    public function __construct(
        CorretorRepository $corretorRepo,
        CorretoraRepository $corretoraRepo,
        EnderecoRepository $enderecoRepo
    ) {
        $this->corretorRepository  = $corretorRepo;
        $this->corretoraRepository = $corretoraRepo;
        $this->enderecoRepository = $enderecoRepo;
    }

    /**
     * Display a listing of the Corretor.
     * GET|HEAD api/v1/corretor
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->corretorRepository->pushCriteria(new RequestCriteria($request));
        $this->corretorRepository->pushCriteria(new LimitOffsetCriteria($request));
        $corretors = $this->corretorRepository->all();

        return $this->sendResponse($corretors->toArray(), 'Corretores recuperados com sucesso');
    }

    /**
     * Store a newly created Corretor in storage.
     * POST api/v1/corretor
     *
     * @param CreateCorretorAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCorretorAPIRequest $request)
    {
        $input = $request->all();
        $pass  = substr(md5(uniqid(rand(), true)).md5(uniqid("")), 0, 8);
        //Inicia o Database Transaction
        DB::beginTransaction();
        
        try {
            $corretora = $this->corretoraRepository->findWhere([
                'cnpj'=>$input['cnpj'],
            ])->first();
            $input['aprovado'] = 'NÃO';
            if (empty($corretora)) {
                $corretora = $this->corretoraRepository->create($input);
                $input['corretora_id'] = $corretora->id;
                $input['tipo'] = 'comercial';
                $endereco = $this->enderecoRepository->create($input);
                $endereco->corretora_id = $corretora->id;
                $endereco->save();
                if (empty($input['mesmo_endereco'])) {
                    $input2 = [
                        "cep" => $input["cep_f"],
                        "uf" => $input["uf_f"],
                        "rua" => $input["rua_f"],
                        "cidade" => $input["cidade_f"],
                        "bairro" => $input["bairro_f"],
                        "numero" => $input["numero_f"],
                        "tipo" => 'fiscal',
                        "complemento" => $input["complemento_f"]
                    ];
                    $endereco_comercial = $this->enderecoRepository->create($input2);
                    $endereco_comercial->corretora_id = $corretora->id;
                    $endereco_comercial->save();
                }
            }

            $corretors = $this->corretorRepository->create($input);
            $user = User::create([
                'name'      => $corretora->descricao,
                'email'     => $corretors->email,
                'password'  => \Hash::make($pass),
                'role_current' => 'cliente_user'
            ]);

            $corretors->user_id = $user->id;
            $corretors->save();
            $user->roles()->attach(Role::where('name', 'corretor_user')->first()->id);
            $corretors->mensagemBoaVinda($pass);
            DB::commit();
        } catch (Exeption $e) {
            DB::rollBack();
            return $this->sendResponse(["Erro"=>"Ocorreu um erro interno, tente novamente mais tarde!"], 'Erro ao salver Corretor');
        }

        return $this->sendResponse($corretors->toArray(), 'Corretor salvo com sucesso');
    }

    /**
     * Display the specified Corretor.
     * GET|HEAD api/v1/corretor/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Corretor $corretor */
        $corretor = $this->corretorRepository->findWithoutFail($id);

        if (empty($corretor)) {
            return $this->sendError('Corretor not found');
        }

        return $this->sendResponse($corretor->toArray(), 'Corretor retrieved successfully');
    }

    /**
     * Update the specified Corretor in storage.
     * PUT/PATCH api/v1/corretor/{id}
     *
     * @param  int $id
     * @param UpdateCorretorAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCorretorAPIRequest $request)
    {
        $input = $request->all();

        /** @var Corretor $corretor */
        $corretor = $this->corretorRepository->findWithoutFail($id);

        if (empty($corretor)) {
            return $this->sendError('Corretor not found');
        }

        $corretor = $this->corretorRepository->update($input, $id);

        return $this->sendResponse($corretor->toArray(), 'Corretor updated successfully');
    }

    /**
     * Remove the specified Corretor from storage.
     * DELETE api/v1/corretor/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Corretor $corretor */
        $corretor = $this->corretorRepository->findWithoutFail($id);

        if (empty($corretor)) {
            return $this->sendError('Corretor not found');
        }

        $corretor->delete();

        return $this->sendResponse($id, 'Corretor deleted successfully');
    }
}
