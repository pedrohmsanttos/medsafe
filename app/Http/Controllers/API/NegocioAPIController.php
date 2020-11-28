<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNegocioAPIRequest;
use App\Http\Requests\API\UpdateNegocioAPIRequest;
use App\Models\Negocio;
use App\Models\User;
use App\Repositories\NegocioRepository;
use App\Repositories\OrganizacaoRepository;
use App\Repositories\PessoaRepository;
use App\Repositories\ProdutosRepository;
use App\Repositories\ProdutoTipoProdutoRepository;
use App\Repositories\MotivoPerdaNegocioRepository;
use App\Repositories\TipoProdutosRepository;
use App\Repositories\CategoriaProdutosRepository;
use App\Repositories\FaturamentosRepository;
use App\Repositories\EnderecoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Crypt;
use DB;

/**
 * Class NegocioController
 * @package App\Http\Controllers\API
 */

class NegocioAPIController extends AppBaseController
{
    /** @var  NegocioRepository */
    private $negocioRepository;

    public function __construct(
        NegocioRepository $negocioRepo,
        OrganizacaoRepository $organizacaoRepo,
        PessoaRepository $pessoaRepo,
        TipoProdutosRepository $tipoProdutosRepo,
        CategoriaProdutosRepository $categoriaProdutosRepo,
        FaturamentosRepository $faturamentoRepository,
        ProdutoTipoProdutoRepository $produtoTipoProdutoRepository,
        ProdutosRepository $produtoRepo,
        EnderecoRepository $enderecoRepo
    ) {
        $this->negocioRepository = $negocioRepo;
        $this->negocioRepository = $negocioRepo;
        $this->organizacaoRepository = $organizacaoRepo;
        $this->pessoaRepository = $pessoaRepo;
        $this->tipoProdutosRepository = $tipoProdutosRepo;
        $this->categoriaProdutosRepository = $categoriaProdutosRepo;
        $this->faturamentoRepository = $faturamentoRepository;
        $this->produtoTipoProdutoRepository = $produtoTipoProdutoRepository;
        $this->produtoRepository = $produtoRepo;
        $this->enderecoRepository = $enderecoRepo;
    }

    /**
     * Display a listing of the Negocio.
     * GET|HEAD /negocios
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->negocioRepository->pushCriteria(new RequestCriteria($request));
        $this->negocioRepository->pushCriteria(new LimitOffsetCriteria($request));
        $negocios = $this->negocioRepository->all();

        return $this->sendResponse($negocios->toArray(), 'Negocios retrieved successfully');
    }

    /**
     * Store a newly created Negocio in storage.
     * POST /negocios
     *
     * @param CreateNegocioAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateNegocioAPIRequest $request)
    {
        $input = $request->all();
        $faturamento = '';

        // Usuário com menos negócios abertos, que tenham permissão
        $colaboradores = [];
        $permissionNegocio = DB::table('permissions')->select('id')->where('name', 'like', 'negocios%')->get();
        $arrTempPer = array_map(function ($item) {
            return $item->id;
        }, $permissionNegocio->toArray());
        
        $arrRoles = DB::table('permission_role')->select('role_id')->whereIn(
            'permission_id',
            $arrTempPer
        )->groupBy('role_id')->get();
        $arrTempRol = array_map(function ($item) {
            return $item->role_id;
        }, $arrRoles->toArray());

        $roles = Role::whereIn(
            'id',
            $arrTempRol
        )->get();
        foreach ($roles as $key => $value) {
            foreach ($value->users()->get() as $user) {
                array_push($colaboradores, $user);
            }
        }
        
        $idsColaboradores = array_map(function ($item) {
            return $item->id;
        }, $colaboradores);

        $arrOrdem = DB::table('negocios')->select('usuario_operacao_id', DB::raw('count(*) as negocios'))->whereIn(
            'usuario_operacao_id',
            $idsColaboradores
        )->where('status', 0)
        ->orderBy('negocios', 'asc')
        ->groupBy('usuario_operacao_id')->get();
        // fim

        // set dates filders
        DB::beginTransaction();
        try {
            $input['telefone'] = $input['telefone_1'] . $input['telefone_2'] . $input['telefone_3'];
            
            if ($input["tipopessoa"] == "pj") {
                $organizacao = $this->organizacaoRepository->findWhere([
                    'email' => $input["email"],
                ])->first();
                
                if (empty($organizacao)) {
                    $organizacao = $this->organizacaoRepository->create($input);
                    $faturamento = $organizacao->faturamento()->first()->descricao;
                    $input['organizacao_id'] = $organizacao->id;
                } else {
                    $faturamento = $organizacao->faturamento()->first()->descricao;
                    $input['organizacao_id'] = $organizacao->id;
                }
            } else {
                $pessoa = $this->pessoaRepository->findWhere([
                    'email' => $input["email"],
                ])->first();

                if (empty($pessoa)) {
                    $pessoa = $this->pessoaRepository->create($input);
                    $input['pessoa_id'] = $pessoa->id;
                } else {
                    $input['pessoa_id'] = $pessoa->id;
                }
            }

            // Campos de datas
            $input['data_criacao']    = date("Y-m-d");
            $input['data_fechamento'] = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string('15 days'));
            $input['data_vencimento'] = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string('10 days'));

            // fazer uma cosulta para recuperar o valor do negócio
            $produtoTipoProduto =  $this->produtoTipoProdutoRepository->findWhere([
                'categoria_produto_id'=>$input['categoria_produto_id'],
                'tipo_produto_id'=>$input['tipo_produto_id']
            ])->first();

            if (!isset($produtoTipoProduto)) {
                throw new \Exception('Produto não disponivel no momento');
            }

            // titulo do negocio
            $input['titulo']  = "NEGOCIAÇÃO via simulação - ";
            $input['titulo'] .= $input['nome'];
            
            //
            $input['status'] = 0;
            $input['usuario_operacao_id'] = $arrOrdem['0']->usuario_operacao_id;
            $input['valor'] = $produtoTipoProduto->valor;
            
            $negocio              = $this->negocioRepository->create($input);
            $negocio->plano       = $produtoTipoProduto->first()->tipoProduto()->first()->descricao;
            $negocio->categoria   = $produtoTipoProduto->first()->categoriaProduto()->first()->descricao;
            $negocio->faturamento = $faturamento;
            // gravar na tabela de ligação NEGOCIO_PRODUTO os campos negocio_id e produto_id
            $negocio->itens()->create([
                'tabela_preco_id' => $produtoTipoProduto->id,
                'valor' => $produtoTipoProduto->valor,
                'quantidade' => 1
            ]);
            DB::commit();

            return $this->sendResponse($negocio->toArray(), 'Negócio salvo com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendError($e);
        }
    }

    /**
     * Display the specified Negocio.
     * GET|HEAD /negocios/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Negocio $negocio */
        $negocio = $this->negocioRepository->findWithoutFail($id);

        if (empty($negocio)) {
            return $this->sendError('Negocio not found');
        }

        return $this->sendResponse($negocio->toArray(), 'Negocio retrieved successfully');
    }

    /**
     * Update the specified Negocio in storage.
     * PUT/PATCH /negocios/{id}
     *
     * @param  int $id
     * @param UpdateNegocioAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNegocioAPIRequest $request)
    {
        $input = $request->all();

        /** @var Negocio $negocio */
        $negocio = $this->negocioRepository->findWithoutFail($id);

        if (empty($negocio)) {
            return $this->sendError('Negocio not found');
        }

        $negocio = $this->negocioRepository->update($input, $id);

        return $this->sendResponse($negocio->toArray(), 'Negocio updated successfully');
    }

    /**
     * Remove the specified Negocio from storage.
     * DELETE /negocios/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Negocio $negocio */
        $negocio = $this->negocioRepository->findWithoutFail($id);

        if (empty($negocio)) {
            return $this->sendError('Negocio not found');
        }

        $negocio->delete();

        return $this->sendResponse($id, 'Negocio deleted successfully');
    }
}
