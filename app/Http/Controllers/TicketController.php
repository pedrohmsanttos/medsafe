<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Repositories\TicketRepository;
use App\Repositories\CategoriaTicketRepository;
use App\Repositories\ClienteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;

class TicketController extends AppBaseController
{
    /** @var  TicketRepository */
    private $ticketRepository;

    /** @var  CategoriaTicketRepository */
    private $categoriaTicketRepository;

    /** @var  ClienteRepository */
    private $clienteRepository;

    public function __construct(
        TicketRepository $ticketRepo,
        CategoriaTicketRepository $categoriaTicketRepo,
        ClienteRepository $clienteRepo
    ) {
        $this->ticketRepository          = $ticketRepo;
        $this->categoriaTicketRepository = $categoriaTicketRepo;
        $this->clienteRepository         = $clienteRepo;
        // Set Permissions
        // $this->middleware('permission:ticket_listar', ['only' => ['index']]);
        // $this->middleware('permission:ticket_adicionar', ['only' => ['create', 'store']]);
        // $this->middleware('permission:ticket_editar', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:ticket_deletar', ['only' => ['destroy']]);
        // $this->middleware('permission:ticket_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Ticket.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Ticket";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Ticket";

        $user = Auth::user();
        
        if (!$user->hasRole('cliente_user')) {
            /** Filtros */
            $this->ticketRepository->pushCriteria(new RequestCriteria($request));
            $cliente_id = (isset($_GET['cliente'])) ?  $_GET['cliente'] : null;
            $filters = $this->ticketRepository->filter($filtros, $cliente_id);
            
            if (isset($filtros['situacao'])) {
                if ($filtros['situacao'] == 'all') {
                    $tickets = $this->ticketRepository->scopeQuery(function ($query) {
                        return $query->withTrashed(); // com deletados
                    })->paginate();
                } elseif ($filtros['situacao'] == 'inativo') {
                    $tickets = $this->ticketRepository->scopeQuery(function ($query) {
                        return $query->onlyTrashed(); // só os deletados
                    })->paginate();
                } else {
                    $tickets = $this->ticketRepository->paginate();
                }
            } else {
                if (isset($_GET['cliente']) && isset($_GET['cpf'])) {
                    $tickets = $this->ticketRepository->scopeQuery(function ($query) use ($filtros) {
                        return $query->whereIn('user_id', [Cliente::find($_GET['cliente'])->usuario->id, Cliente::where('CNPJCPF', $filtros['cpf'])->first()->usuario->id]);
                    })->paginate();
                } elseif (isset($_GET['cliente'])) {
                    $tickets = $this->ticketRepository->scopeQuery(function ($query) use ($filtros) {
                        return $query->where('user_id', Cliente::find($_GET['cliente'])->usuario->id);
                    })->paginate();
                } elseif (isset($_GET['cpf'])) {
                    $cliente = Cliente::where('CNPJCPF', $filtros['cpf'])->first();
                    if (isset($cliente)) {
                        $tickets = $this->ticketRepository->scopeQuery(function ($query) use ($cliente) {
                            return $query->where('user_id', $cliente->usuario->id);
                        })->paginate();
                    } else {
                        $tickets = $this->ticketRepository->paginate();
                    }
                }
                $tickets = $this->ticketRepository->paginate();
            }
        } else {
            $filters = [];
            $req = new Request();
            $req->attributes->add(['search'=>'user_id:'.$user->id]);
            $req->attributes->add(['searchFields'=>'user_id:=']);
            $req->attributes->add(['orderBy' => 'id']);
            $req->attributes->add(['sortedBy' => 'desc']);
            $this->ticketRepository->pushCriteria(new RequestCriteria($req));
            $tickets = $this->ticketRepository->paginate();
        }

        $categorias = $this->categoriaTicketRepository->all();
        $clientes   = Cliente::whereNotNull('user_id')->get();
        
        return view('tickets.index', compact('title', 'breadcrumb', 'tickets', 'filters', 'categorias', 'clientes'));
    }

    /**
     * Show the form for creating a new Ticket.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Solicitar Atendimento";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addTicket";

        $categorias = $this->categoriaTicketRepository->all();

        return view('tickets.create', compact('title', 'breadcrumb', 'categorias'));
    }

    /**
     * Store a newly created Ticket in storage.
     *
     * @param CreateTicketRequest $request
     *
     * @return Response
     */
    public function store(CreateTicketRequest $request)
    {
        $input = $request->all();
        $input['user_id']    = Auth::user()->id;
        $input['prioridade'] = 0;
        $input['status']     = 0;

        $ticket = $this->ticketRepository->create($input);

        Flash::success('Ticket salvo com sucesso.');

        return redirect(route('tickets.index'));
    }

    /**
     * Display the specified Ticket.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ticket = $this->ticketRepository->findWithoutFail($id);

        if (empty($ticket)) {
            Flash::error('Ticket não encontrado');

            return redirect(route('tickets.index'));
        }
        
        /** Titulo da página */
        $title = "Ticket";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome    = "showTicket";
        $breadcrumb->id      = $ticket->id;
        $breadcrumb->titulo  = $ticket->titulo;

        return view('tickets.show', compact('title', 'breadcrumb', 'ticket'));
    }

    /**
     * Show the form for editing the specified Ticket.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ticket = $this->ticketRepository->findWithoutFail($id);

        if (empty($ticket)) {
            Flash::error('Ticket não encontrado');

            return redirect(route('tickets.index'));
        }

        // Titulo da página
        $title = "Ticket";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editTicket";
        $breadcrumb->id = $ticket->id;
        $breadcrumb->titulo = $ticket->id;

        return view('tickets.edit', compact('title', 'breadcrumb', 'ticket'));
    }

    /**
     * Update the specified Ticket in storage.
     *
     * @param  int              $id
     * @param UpdateTicketRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTicketRequest $request)
    {
        $ticket = $this->ticketRepository->findWithoutFail($id);

        if (empty($ticket)) {
            Flash::error('Ticket não encontrado');

            return redirect(route('tickets.index'));
        }

        $ticket = $this->ticketRepository->update($request->all(), $id);

        Flash::success('Ticket atualizado com sucesso.');

        return redirect(route('tickets.index'));
    }

    /**
     * Remove the specified Ticket from storage.
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
                $this->ticketRepository->delete($id);
            }

            DB::commit();
            Flash::success('Ticket(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Ticket(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
