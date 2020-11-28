<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNegocioRequest;
use App\Http\Requests\UpdateNegocioRequest;
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
use App\Http\Controllers\AppBaseController;
use App\Models\Negocio;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;
use Auth;
use App\Traits\NegocioTrait;

class NegocioController extends AppBaseController
{
    /** @var  NegocioRepository */
    private $negocioRepository;
    /** @var  OrganizacaoRepository */
    private $organizacaoRepository;
    /** @var  PessoaRepository */
    private $pessoaRepository;
    /** @var  MotivoPerdaNegocioRepository */
    private $motivoPerdaNegocioRepository;
    /** @var  TipoProdutosRepository */
    private $tipoProdutosRepository;
    /** @var  CategoriaProdutosRepository */
    private $categoriaProdutosRepository;
    /** @var  FaturamentoRepository */
    private $faturamentoRepository;
    /** @var  ProdutoTipoProdutoRepository */
    private $produtoTipoProdutoRepository;
    /** @var  ProdutoRepository */
    private $produtoRepository;
    /** @var  EnderecoRepository */
    private $enderecoRepository;

    // Logic
    use NegocioTrait;


    public function __construct(
        NegocioRepository $negocioRepo,
        OrganizacaoRepository $organizacaoRepo,
        PessoaRepository $pessoaRepo,
        MotivoPerdaNegocioRepository $motivoPerdaNegocioRepository,
        TipoProdutosRepository $tipoProdutosRepo,
        CategoriaProdutosRepository $categoriaProdutosRepo,
        FaturamentosRepository $faturamentoRepository,
        ProdutoTipoProdutoRepository $produtoTipoProdutoRepository,
        ProdutosRepository $produtoRepo,
        EnderecoRepository $enderecoRepo
        ) {
        $this->negocioRepository = $negocioRepo;
        $this->organizacaoRepository = $organizacaoRepo;
        $this->pessoaRepository = $pessoaRepo;
        $this->motivoPerdaNegocioRepository = $motivoPerdaNegocioRepository;
        $this->tipoProdutosRepository = $tipoProdutosRepo;
        $this->categoriaProdutosRepository = $categoriaProdutosRepo;
        $this->faturamentoRepository = $faturamentoRepository;
        $this->produtoTipoProdutoRepository = $produtoTipoProdutoRepository;
        $this->produtoRepository = $produtoRepo;
        $this->enderecoRepository = $enderecoRepo;
        // Set Permissions
        $this->middleware('permission:negocios_listar', ['only' => ['index']]);
        $this->middleware('permission:negocios_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:negocios_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:negocios_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:negocios_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Negocio.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();
        $user    = Auth::user();
        /** Titulo da página */
        $title = "Negócio";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "negocio";

        if ($user->hasRole('corretor_user')) {
            $req = new Request();
            $req->attributes->add(['search'=>'usuario_operacao_id:'.$user->id]);
            $req->attributes->add(['searchFields'=>'usuario_operacao_id:=']);
           
        }

         
        if (!empty($filtros['search']) && !empty($request['search'])) {
            $explodeSearch = explode(":", $filtros['search']);
            if ($explodeSearch[0] == "data_criacao" ) {
                //$data = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $explodeSearch[1])));
                $data = date('Y-m-d', strtotime(str_replace("/", "-", $explodeSearch[1])));
                $filtros['search'] = $explodeSearch[0] . ":" . $data;
                $request['search'] = $explodeSearch[0] . ":" . $data;
            }
        }

        $request = $this->setOrderBy($request);
        $this->negocioRepository->pushCriteria(new RequestCriteria($request));

        $filters = $this->negocioRepository->filter($filtros);
        
        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $negocios = $this->negocioRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $negocios = $this->negocioRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $negocios = $this->negocioRepository->paginate();
            }
        }
       else {
            $negocios = $this->negocioRepository->paginate();
        }
        $pessoas        = $this->pessoaRepository->all();
        $organizacoes   = $this->organizacaoRepository->all();
        
        return view('negocios.index', compact('title', 'breadcrumb', 'negocios', 'filters','pessoas','organizacoes'));
    }

    /**
     * Show the form for creating a new Negocio.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Negócio";
        
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addNegocio";

        /** Attrs */
        $negocio                          = new \App\Models\Negocio;
        $negocio->organizacao_id          = "";
        $negocio->pessoa_id               = "";
        $negocio->motivo_perda_negocio_id = "";
        $categorias                       = $this->categoriaProdutosRepository->all();
        $tipos                            = $this->tipoProdutosRepository->all();
        $faturamentos                     = $this->faturamentoRepository->all();
        $produtos                         = $this->produtoRepository->all();
        $usuarios                         = User::all();
        $currentUser                      = Auth::user();

        return view('negocios.create', compact('title', 'breadcrumb', 'negocio', 'usuarios', 'currentUser', 'categorias', 'tipos', 'faturamentos', 'produtos'));
    }

    /**
     * Store a newly created Negocio in storage.
     *
     * @param CreateNegocioRequest $request
     *
     * @return Response
     */
    public function store(CreateNegocioRequest $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            $this->__load($input);

            // save negócio
            $negocio  = $this->negocioRepository->create($this->getNegocio());
            
            if (empty($input['endereco_id'])) {
                $input['endereco_id'] = 0;
            }

            if (isset($input['pessoa_id'])) {
                $negocio->pessoa()->associate($this->pessoaRepository->findWithoutFail($input['pessoa_id']));
            } elseif (isset($input['organizacao_id'])) {
                $negocio->organizacao()->associate($this->organizacaoRepository->findWithoutFail($input['organizacao_id']));
            }

            if ($this->isOrganizacao()) {
                $organizacao = $this->organizacaoRepository->updateOrCreate(['email'=>$this->getEmail()], $this->getSolicitante());
                $organizacao->enderecos()->updateOrCreate(['id' => $input['endereco_id']], $this->getEndereco());
                $negocio->organizacao_id = $organizacao->id;
            } else {
                $pessoa = $this->pessoaRepository->updateOrCreate(['email'=>$this->getEmail()], $this->getSolicitante());
                $pessoa->enderecos()->updateOrCreate(['id' => $input['endereco_id']], $this->getEndereco());
                $negocio->pessoa_id = $pessoa->id;
            }

            // save itens
            $negocio->itens()->createMany($this->getItens());

            $negocio->save();

            DB::commit();
            Flash::success('Negócio salvo com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            Flash::error('Erro ao tentar cadastrar Negócio');
        }
        return redirect(route('negocios.index'));
    }

    /**
     * Display the specified Negocio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $negocio = $this->negocioRepository->findWithoutFail($id);
        if (empty($negocio)) {
            Flash::error('Negócio não encontrado');

            return redirect(route('negocios.index'));
        }
        // Titulo da página
        $title = "Negócio: ". $negocio->descricao;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showNegocio";
        $breadcrumb->titulo = $negocio->descricao;
        return view('negocios.show', compact('title', 'breadcrumb', 'negocio'));
    }

    /**
     * Show the form for editing the specified Negocio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $negocio  = $this->negocioRepository->findWithoutFail($id);

        if (empty($negocio)) {
            Flash::error('Negócio não encontrado!');

            return redirect(route('negocios.index'));
        }
        // Titulo da página
        $codigo = str_pad($negocio->id, 8, "0", STR_PAD_LEFT);
        $title  = "Negócio: ". "[".$codigo."] " .$negocio->titulo;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome   = "editNegocio";
        $breadcrumb->id     = $negocio->id;
        $breadcrumb->titulo = "[".$codigo."] ".$negocio->titulo;

        $faturamentos       = $this->faturamentoRepository->all();
        $produtoTipoProduto = $negocio->produtos()->first();
        $produtos           = $this->produtoRepository->all();
        $usuarios           = User::all();
        $currentUser        = Auth::user();
        $lancamentoRecebers = $negocio->lancamentosReceber();

        if ($negocio->pessoa()->first() != null) {
            $endereco = $negocio->pessoa()->first()->enderecos()->first();
        }
        if ($negocio->organizacao()->first() != null) {
            $endereco = $negocio->organizacao()->first()->enderecos()->first();
        }
        
        return view('negocios.edit', compact('title', 'breadcrumb', 'codigo', 'pessoas', 'organizacaos', 'negocio', 'motivoPerdaNegocios', 'categorias', 'tipos', 'faturamentos', 'produtoTipoProduto', 'endereco', 'lancamentoRecebers', 'produtos', 'usuarios', 'currentUser'));
    }

    /**
     * Update the specified Negocio in storage.
     *
     * @param  int              $id
     * @param UpdateNegocioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNegocioRequest $request)
    {
        $input = $request->all();

        $negocio = $this->negocioRepository->findWithoutFail($id);
        if ($negocio->pessoa()->first() != null) {
            $negocio->pessoa()->update($input);
            if (is_null($negocio->pessoa()->first()->enderecos()->first())) {
                $input['pessoa_id'] = $negocio->pessoa_id;
                $endereco = $this->enderecoRepository->create($input);
                $negocio->pessoa()->first()->enderecos()->saveMany([$endereco]);
            } else {
                $endereco = $negocio->pessoa()->first()->enderecos()->first();
            }
        }
        if ($negocio->organizacao()->first() != null) {
            $negocio->organizacao()->update($input);
            if (is_null($negocio->organizacao()->first()->enderecos()->first())) {
                $input['organizacao_id'] = $negocio->organizacao_id;
                $endereco = $this->enderecoRepository->create($input);
                $negocio->organizacao()->first()->enderecos()->saveMany([$endereco]);
            } else {
                $endereco = $negocio->organizacao()->first()->enderecos()->first();
            }
        }

        if (empty($negocio) || empty($endereco)) {
            Flash::error('Negócio não enontrado.');

            return redirect(route('negocios.index'));
        }

        DB::beginTransaction();
        try {
            $negocio  = $this->negocioRepository->update($input, $id);
            $endereco = $this->enderecoRepository->update($input, $endereco->id);

            DB::commit();
            //Flash::success('Negócio atualizao com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            //Flash::error('Erro ao tentar atualizao Negócio');
        }
        Flash::success('Negócio atualizao com sucesso.');

        return redirect(route('negocios.index'));
    }

    /**
     * Remove the specified Negocio from storage.
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
                $this->negocioRepository->delete($id);
            }

            DB::commit();
            Flash::success('Negócio(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Negocio(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }

    /**
     * Copy registe from database.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function copy($id)
    {
        $negocio    = $this->negocioRepository->findWithoutFail($id);
        $negocio_cp = $negocio;
        $negocio_cp->copia = true;
        $negocio_cp->status = 0;

        /** Titulo da página */
        $title = "Adicionar Negócio (Copia de ".$id.")";
        
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addNegocio";

        /** Attrs */
        $categorias                       = $this->categoriaProdutosRepository->all();
        $tipos                            = $this->tipoProdutosRepository->all();
        $faturamentos                     = $this->faturamentoRepository->all();
        $produtos                         = $this->produtoRepository->all();
        $usuarios                         = User::all();
        $currentUser                      = Auth::user();

        if ($negocio->pessoa()->first() != null) {
            $endereco = $negocio->pessoa()->first()->enderecos()->first();
        }
        if ($negocio->organizacao()->first() != null) {
            $endereco = $negocio->organizacao()->first()->enderecos()->first();
        }

        return view('negocios.create', compact('title', 'breadcrumb', 'negocio_cp', 'negocio', 'usuarios', 'currentUser', 'categorias', 'tipos', 'faturamentos', 'produtos', 'endereco'));
    }

    /**
     * transferir.
     *
     * @return Response
     */
    public function transferir()
    {
        /** Titulo da página */
        $title = "Transferir Negócios";
        
        /** Breadcrumb */
        $breadcrumb       = new \stdClass;
        $breadcrumb->nome = "addNegocio";

        /** Attrs */
        $usuarios    = User::all();
        $currentUser = Auth::user();
        $negocios    = $this->negocioRepository->findWhere(['usuario_operacao_id'=>Auth::user()->id,'status'=>0])->all();

        return view('negocios.transferir', compact('title', 'breadcrumb', 'usuarios', 'currentUser', 'negocios'));
    }

    /**
     * doTransferir.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function doTransferir(Request $request)
    {
        $input = $request->all();
        
        if (isset($input['usuario_operacao_id'])) {
            DB::beginTransaction();
            try {
                $negocio  = Negocio::where('usuario_operacao_id', Auth::user()->id)
                    ->where('status', 0)
                    ->update(['usuario_operacao_id' => $input['usuario_operacao_id']]);

                DB::commit();
                Flash::success('Negócio(s) transferido(s) com sucesso.');
            } catch (\Exception $e) {
                DB::rollBack();
                Flash::error('Erro ao tentar transferir Negócio');
            }
        }

        return redirect(route('negocios.index'));
    }
}
