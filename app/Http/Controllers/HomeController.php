<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NegocioRepository;
use App\Repositories\ItemRepository;
use App\Repositories\NovidadeRepository;
use App\Repositories\ApoliceRepository;
use Khill\Lavacharts\Lavacharts;
use App\Models\User;
use App\Models\Parametro;
use Auth;
use DB;
use Lava;

class HomeController extends Controller
{
    /** @var  NegocioRepository */
    private $negocioRepository;
    
    /** @var  ApoliceRepository */
    private $apoliceRepository;

    /** @var  ItemRepository */
    private $itemRepository;

    /** @var  NovidadeRepository */
    private $novidadeRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        NegocioRepository $negocioRepo,
        ItemRepository $itemRepo,
        NovidadeRepository $novidadeRepo,
        ApoliceRepository $apoliceRepo
    ) {
        $this->middleware('auth');
        $this->negocioRepository = $negocioRepo;
        $this->itemRepository    = $itemRepo;
        $this->novidadeRepository = $novidadeRepo;
        $this->apoliceRepository = $apoliceRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Meu Espaço";
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "dashboard";

        $desc_status = [
            'EM ABERTO', 'PERDIDO', 'GANHO', 'EXCLUÍDO'
        ];

        // TOP 10 funcionários
        $topFuncionarios   = $this->negocioRepository->scopeQuery(function ($query) {
            return $query->select(DB::raw('count(*) as quantidade, usuario_operacao_id'))->where('status', 2)->groupBy('usuario_operacao_id')->orderBy('quantidade', 'desc')->withTrashed();
        })->paginate(10);

        // TOP 5 serviços
        $topServicos       = $this->itemRepository->scopeQuery(function ($query) {
            return $query->select(DB::raw('count(*) as quantidade, tabela_preco_id'))->groupBy('tabela_preco_id')->orderBy('quantidade', 'desc');
        })->paginate(5);
        $arrTopServicos    = $topServicos->toArray()['data'];
        foreach ($arrTopServicos as $key => $value) {
            # code...
        }

        // Negociações
        $statusNegociacoes = $this->negocioRepository->scopeQuery(function ($query) {
            return $query->select(DB::raw('count(*) as quantidade, status'))->groupBy('status')->withTrashed();
        })->all();

        // Pie options
        $negociacoes = Lava::DataTable();
        $negociacoes->addStringColumn('Status')
            ->addNumberColumn('Quantidade');

        foreach ($statusNegociacoes as $status) {
            $negociacoes->addRow([$desc_status[$status->status], $status->quantidade]);
        }
        
        Lava::PieChart('Negociacoes', $negociacoes, [
            'title'  => 'Status das negociações',
            'is3D'   => false,
            'slices' => [
                ['offset' => 0.2],
                ['offset' => 0.25],
                ['offset' => 0.3]
            ]
        ]);

        // Novidades
        $novidades = $this->novidadeRepository->orderBy('id', 'desc')->paginate(10);
        
        $user = Auth::user();

        if ($user->hasRole('corretor_user')) {
            $parametro = Parametro::where('nome','apolices para renovação')->get()[0];
            date_default_timezone_set('America/Recife');
            $dataHoje = date('Y-m-d', time());
            $data = date('Y-m-d', strtotime($dataHoje. ' + '.trim($parametro->valor).' days'));
            $renovacoesProximas = $this->renovacoesProximas($user, $data, $dataHoje);
            //$renovacoesHoje = $this->renovacoesHoje($user, $dataHoje);
            $ativacoesMes = $this->ativacoesMes($user);
            $ativacoesHoje = $this->ativacoesHoje($user,$dataHoje);
            $ativacoesMesAnterior = $this->ativacoesMesAnterior($user);
            $numAtivacoesMes = $this->ativacoesMesCount($user);
            $conclusaoPercentual = $this->getPercentualAtivacao($numAtivacoesMes, $ativacoesMesAnterior );
        } 
        

        return view('home', compact('title', 'breadcrumb', 'topFuncionarios','numAtivacoesMes', 'topServicos','renovacoesProximas','conclusaoPercentual','ativacoesHoje','ativacoesMesAnterior','ativacoesMes', 'negociacoes', 'novidades'));
    }

    /**
     * Show profile user.
     *
     * @return \Illuminate\Http\Response
     */
    public function meuperfil()
    {
        $title = "Meu Perfil";
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "meuperfil";
        $user = Auth::user();

        return view('perfil.index', compact('title', 'breadcrumb', 'user'));
    }

    /**
     * Logout and redirect.
     *
     * @return Route
     */
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    /**
     * Change profile.
     *
     * @return Route
     */
    public function trocarperfil(Request $request)
    {
        $user = Auth::user();
        $user->role_current = $request->role;
        $user->update();
        return redirect('/');
    }

    public function renovacoesHoje($user, $dataHoje)
    {
        return DB::table('apolices')->join('clientes', 'apolices.cliente_id', '=', 'clientes.id')
        ->where('corretor_id','=',$user->corretor()->first()->id)
        ->where('status','=',1)
        ->where('data_vencimento','=',$dataHoje)
        ->select('apolices.*', 'clientes.nomeFantasia as nome')
        ->get();
    }

    public function renovacoesProximas($user, $data, $dataHoje)
    {
        return DB::table('apolices')->join('clientes', 'apolices.cliente_id', '=', 'clientes.id')
        ->where('corretor_id','=',$user->corretor()->first()->id)
        ->where('status','=',1)
        ->where('data_vencimento','<=',$data)->where('data_vencimento','>',$dataHoje)
        ->select('apolices.*', 'clientes.nomeFantasia as nome')
        ->limit(10)->orderBy('data_vencimento', 'asc')
        ->get();
    }

    public function ativacoesHoje($user, $dataHoje)
    {
        return DB::table('apolices')->join('clientes', 'apolices.cliente_id', '=', 'clientes.id')
        ->where('corretor_id','=',$user->corretor()->first()->id)
        ->where('status','=',1)
        ->where('data_ativacao','=',$dataHoje)
        ->select('apolices.*', 'clientes.nomeFantasia as nome')
        ->get();
    }

    public function ativacoesMes($user)
    {

        date_default_timezone_set('America/Recife');
        $mes = date('Y-m-01', time());
        $proximoMes = date('Y-m-d', strtotime($mes. ' +1 months'));
        $mesAnterior = date('Y-m-d', strtotime($mes. ' -1 months'));
        //dd($mes);
        return DB::table('apolices')->join('clientes', 'apolices.cliente_id', '=', 'clientes.id')
        ->where('corretor_id','=',$user->corretor()->first()->id)
        ->where('data_ativacao','>=',$mes)->where('data_ativacao','<',$proximoMes)
        ->select('apolices.*', 'clientes.nomeFantasia as nome')
        ->limit(10)->orderBy('data_ativacao', 'asc')
        ->get();
    }

    public function ativacoesMesAnterior($user)
    {

        date_default_timezone_set('America/Recife');
        $mes = date('Y-m-01', time());
        $proximoMes = date('Y-m-d', strtotime($mes. ' +1 months'));
        $mesAnterior = date('Y-m-d', strtotime($mes. ' -1 months'));
        //dd($mes);
        return DB::table('apolices')->join('clientes', 'apolices.cliente_id', '=', 'clientes.id')
        ->where('corretor_id','=',$user->corretor()->first()->id)
        ->where('data_ativacao','>=',$mesAnterior)->where('data_ativacao','<',$mes)
        ->select('apolices.*', 'clientes.nomeFantasia as nome')
        ->orderBy('data_ativacao', 'asc')
        ->count();
    }

    public function getPercentualAtivacao($mesAtual, $mesAnterior)
    {
        if( $mesAtual == 0){
            return "No mês atual ainda não houve ativações";
        }

        if ( $mesAnterior == 0){
            return "No mês anterior não houve ativações";
        }
        $valorPercentual = $mesAtual / $mesAnterior;
        $valorPercentual = number_format($valorPercentual, 2, '.', '');
        if( $valorPercentual > 1 ){
            $aumento = ($valorPercentual - 1) * 100;
            $aumento = number_format($aumento, 2, '.', '');
            return "O número de ativações atualmente está com aumento de ".$aumento."% comparado ao mês anterior";
        } else if( $valorPercentual == 1 ){
            return "O número de ativações atualmente está igual comparado ao mês anterior, que foi de: ".$mesAnterior." ativações";
        } else {
            $reducao = ($valorPercentual - 1) * 100 *-1;
            $reducao = number_format($reducao, 2, '.', '');
            return "O número de ativações atualmente está com redução de ".$reducao."% comparado ao mês anterior";
        }
    }

    public function ativacoesMesCount($user)
    {

        date_default_timezone_set('America/Recife');
        $mes = date('Y-m-01', time());
        $proximoMes = date('Y-m-d', strtotime($mes. ' +1 months'));
        $mesAnterior = date('Y-m-d', strtotime($mes. ' -1 months'));
        //dd($mes);
        return DB::table('apolices')->join('clientes', 'apolices.cliente_id', '=', 'clientes.id')
        ->where('corretor_id','=',$user->corretor()->first()->id)
        ->where('data_ativacao','>=',$mes)->where('data_ativacao','<',$proximoMes)
        ->select('apolices.*', 'clientes.nomeFantasia as nome')
        ->orderBy('data_ativacao', 'asc')
        ->count();
    }

}
