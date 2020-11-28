<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGanhoNegocioRequest;
use App\Http\Requests\UpdateGanhoNegocioRequest;
use App\Repositories\GanhoNegocioRepository;
use App\Repositories\NegocioRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\PedidoRepository;
use App\Repositories\ProdutoTipoProdutoRepository;
use App\Repositories\PedidoTipoProdutoRepository;
use App\Repositories\NegocioProdutoRepository;
use App\Repositories\LancamentoReceberRepository;
use App\Repositories\EspecialidadeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Negocio;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Role;
use App\Models\ProdutoTipoProduto;
use App\Models\NegocioProduto;
use App\Models\PedidoTipoProduto;
use App\Models\LancamentoReceber;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DateTime;
use DB;
use Auth;
use App\Traits\GanhoNegocioTrait;

class GanhoNegocioController extends AppBaseController
{
    /** @var  GanhoNegocioRepository */
    private $ganhoNegocioRepository;

    /** @var  NegocioRepository */
    private $negocioRepository;

    /** @var  ClienteRepository */
    private $clienteRepository;

    /** @var  EnderecoRepository */
    private $enderecoRepository;

    /** @var  PedidoRepository */
    private $pedidoRepository;

    /** @var  EspecialidadeRepository */
    private $especialidadeRepository;

    /** @var  ProdutoTipoProdutoRepository */
    private $produtoTipoProdutoRepository;

    /** @var  NegocioProdutoRepository */
    private $negocioProdutoRepository;

    /** @var  PedidoTipoProdutoRepository */
    private $pedidoTipoProdutoRepository;

    /** @var  LancamentoReceberRepository */
    private $lancamentoReceberRepository;

    // Logic
    use GanhoNegocioTrait;

    public function __construct(
        GanhoNegocioRepository $ganhoNegocioRepo,
        NegocioRepository $negocioRepo,
        ClienteRepository $clienteRepo,
        EnderecoRepository $enderecoRepo,
        PedidoRepository $pedidoRepo,
        ProdutoTipoProdutoRepository $produtoTipoProdutoRepo,
        NegocioProdutoRepository $negocioProdutoRepo,
        PedidoTipoProdutoRepository $pedidoTipoProdRepo,
        LancamentoReceberRepository $lancamentoReceberRepo,
        EspecialidadeRepository $especialidadeRepo
    ) {
        $this->ganhoNegocioRepository               = $ganhoNegocioRepo;
        $this->negocioRepository                    = $negocioRepo;
        $this->clienteRepository                    = $clienteRepo;
        $this->enderecoRepository                   = $enderecoRepo;
        $this->pedidoRepository                     = $pedidoRepo;
        $this->produtoTipoProdutoRepository         = $produtoTipoProdutoRepo;
        $this->negocioProdutoRepository             = $negocioProdutoRepo;
        $this->pedidoTipoProdutoRepository          = $pedidoTipoProdRepo;
        $this->lancamentoReceberRepository          = $lancamentoReceberRepo;
        $this->especialidadeRepository          = $especialidadeRepo;
    }

    /**
     * Display a listing of the GanhoNegocio.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Ganho de Negócio";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "GanhoNegocio";
        /** Filtros */
        $this->ganhoNegocioRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->ganhoNegocioRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $ganhoNegocios = $this->ganhoNegocioRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $ganhoNegocios = $this->ganhoNegocioRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $ganhoNegocios = $this->ganhoNegocioRepository->paginate();
            }
        } else {
            $ganhoNegocios = $this->ganhoNegocioRepository->paginate();
        }

        return view('ganho_negocios.index', compact('title', 'breadcrumb', 'ganhoNegocios', 'filters'));
    }

    /**
     * Show the form for creating a new GanhoNegocio.
     *
     * @return Response
     */
    public function create($idNegocio)
    {
        /** Titulo da página */
        $title = "Ganho de Negócio";

        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addGanhoNegocio";

        /** Attrs */
        $negocios       = $this->negocioRepository->all()->where('id', $idNegocio);
        $usuarios       = User::all();
        $currentUser    = Auth::user();
        $currentnegocio = new \stdClass;
        $cliente        = new Cliente;
        $especialidades = $this->especialidadeRepository->all();
        
        if (!empty($idNegocio)) {
            $currentnegocio      = $this->negocioRepository->findWithoutFail($idNegocio);
            $pessoa              = $currentnegocio->pessoa()->first();
            $organizacao         = $currentnegocio->organizacao()->first();

            if ($pessoa != null) {
                $tempCLiente = Cliente::where('email', $pessoa->email)->first();
                if (!empty($tempCLiente)) {
                    $cliente  = $tempCLiente;
                    $endereco = $tempCLiente->endereco()->first();
                } else {
                    $cliente->razaoSocial   = $pessoa->nome;
                    $cliente->nomeFantasia  = $pessoa->nome;
                    $cliente->nomeTitular   = $pessoa->nome;
                    $cliente->email         = $pessoa->email;
                    $cliente->telefone      = $pessoa->telefone;
                    $cliente->tipoPessoa    = "pf";
                    $endereco               = $pessoa->enderecos()->first();
                }
            } elseif ($organizacao != null) {
                $tempCLiente = Cliente::where('email', $organizacao->email)->first();
                if (!empty($tempCLiente)) {
                    $cliente  = $tempCLiente;
                    $endereco = $tempCLiente->endereco()->first();
                } else {
                    $cliente->razaoSocial   = $organizacao->nome;
                    $cliente->nomeFantasia  = $organizacao->nome;
                    $cliente->nomeTitular   = $organizacao->nome;
                    $cliente->email         = $organizacao->email;
                    $cliente->telefone      = $organizacao->telefone;
                    $cliente->tipoPessoa    = "pj";
                    $endereco               = $organizacao->enderecos()->first();
                }
            }
        } else {
            $currentnegocio->id = 0;
        }

        return view('ganho_negocios.create', compact('title','especialidades', 'breadcrumb', 'negocios', 'usuarios', 'currentUser', 'currentnegocio', 'cliente', 'pessoa', 'endereco'));
    }

    /**
     * Store a newly created GanhoNegocio in storage.
     *
     * @param CreateGanhoNegocioRequest $request
     *
     * @return Response
     */
    public function store(CreateGanhoNegocioRequest $request)
    {
        $input        = $request->all();
        $negocio      = $this->negocioRepository->findWithoutFail($input['negocio_id']);
        // temp
        if (isset($input['funcao_pj'])) {
            $input['funcao'] = $input['funcao_pj'];
        }
        if (isset($input['CNPJCPF_pj'])) {
            $input['CNPJCPF'] = $input['CNPJCPF_pj'];
        }
        if (isset($input['nomeFantasia_pj'])) {
            $input['nomeFantasia'] = $input['nomeFantasia_pj'];
        }
        if (isset($input['telefone_pj'])) {
            $input['telefone'] = $input['telefone_pj'];
        }
        if (isset($input['email_pj'])) {
            $input['email'] = $input['email_pj'];
        }
        
        $input['data_vencimento'] = 'NOW()';
        
        
        $idNegocio  = $negocio->id;
        
        if (empty($negocio)) {
            Flash::error('Negócio não encontrado ou inativado!');

            return redirect(url('negocios/'.$input['negocio_id'].'/ganho/create'));
        }
        
        DB::beginTransaction();
        try {
            $this->__load($input);
            // Negócio
            $ganhoNegocio                       = $this->ganhoNegocioRepository->create($this->getGanho());
            $ganhoNegocio->negocio->data_ganho  = $this->getDataGanho();
            $ganhoNegocio->negocio->status      = '2';
            $ganhoNegocio->negocio->save();
            
            // Cliente
            $cliente      = $this->clienteRepository->updateOrCreate(['CNPJCPF' => $input['CNPJCPF']], $this->getCliente());
            if (isset($input['endereco_id'])) {
                $endereco     = $this->enderecoRepository->updateOrCreate(['id' => $input['endereco_id']], $this->getEndereco());
            } else {
                $endereco     = $this->enderecoRepository->create($this->getEndereco());
            }
            $endereco->cliente_id = $cliente->id;
            $endereco->save();
            // User
            $clienteUser = User::where('email', $cliente->email)->first();
            if (!empty($clienteUser)) {
                $clienteRole = Role::where('name', 'cliente_user')->first();
                if (!$clienteUser->_hasRole('cliente_user')) {
                    //$clienteUser->role_current = 'cliente_user';
                    $clienteUser->roles()->attach($clienteRole);
                }
            }
            // Pedido
            $pedido  = $this->pedidoRepository->create($this->getPedido($cliente, $ganhoNegocio->negocio()->first()));
            $pedido->itens()->saveMany($ganhoNegocio->negocio()->first()->itens()->get());
            
            DB::commit();
            Flash::success('Negócio salvo com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            Flash::error('Erro ao tentar ganhar negócio');
        }

        return redirect(url('/negocios'));
    }

    /**
     * Display the specified GanhoNegocio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Ganho de Negócio";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showGanhoNegocio";
        
        $ganhoNegocio = $this->ganhoNegocioRepository->findWithoutFail($id);

        if (empty($ganhoNegocio)) {
            Flash::error('Ganho de Negócio não encontrado');

            return redirect(route('ganhoNegocios.index'));
        }

        return view('ganho_negocios.show', compact('title', 'breadcrumb', 'ganhoNegocio'));
    }

    /**
     * Show the form for editing the specified GanhoNegocio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ganhoNegocio = $this->ganhoNegocioRepository->findWithoutFail($id);

        if (empty($ganhoNegocio)) {
            Flash::error('Ganho de Negócio não encontrado');

            return redirect(route('ganhoNegocios.index'));
        }

        // Titulo da página
        $title = "Ganho de Negócio";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editGanhoNegocio";
        $breadcrumb->id = $ganhoNegocio->id;
        $breadcrumb->titulo = $ganhoNegocio->id;

        return view('ganho_negocios.edit', compact('title', 'breadcrumb', 'ganhoNegocio'));
    }

    /**
     * Update the specified GanhoNegocio in storage.
     *
     * @param  int              $id
     * @param UpdateGanhoNegocioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGanhoNegocioRequest $request)
    {
        $ganhoNegocio = $this->ganhoNegocioRepository->findWithoutFail($id);

        if (empty($ganhoNegocio)) {
            Flash::error('Ganho de Negócio não encontrado');

            return redirect(route('ganhoNegocios.index'));
        }

        $ganhoNegocio = $this->ganhoNegocioRepository->update($request->all(), $id);

        Flash::success('Ganho de Negócio atualizado com sucesso.');

        return redirect(route('ganhoNegocios.index'));
    }

    /**
     * Remove the specified GanhoNegocio from storage.
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
                $this->ganhoNegocioRepository->delete($id);
            }

            DB::commit();
            Flash::success('Ganho de Negócio(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Ganho de Negócio(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
