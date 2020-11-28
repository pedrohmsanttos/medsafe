<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoriaTicketRequest;
use App\Http\Requests\UpdateCategoriaTicketRequest;
use App\Repositories\CategoriaTicketRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\CategoriaTicket;
use App\Models\Ticket;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class CategoriaTicketController extends AppBaseController
{
    /** @var  CategoriaTicketRepository */
    private $categoriaTicketRepository;

    public function __construct(CategoriaTicketRepository $categoriaTicketRepo)
    {
        $this->categoriaTicketRepository = $categoriaTicketRepo;
        // Set Permissions
        // $this->middleware('permission:categoriaTicket_listar', ['only' => ['index']]);
        // $this->middleware('permission:categoriaTicket_adicionar', ['only' => ['create', 'store']]);
        // $this->middleware('permission:categoriaTicket_editar', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:categoriaTicket_deletar', ['only' => ['destroy']]);
        // $this->middleware('permission:categoriaTicket_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the CategoriaTicket.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Categoria de Solicitações";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "CategoriaTicket";
        /** Filtros */
        $this->categoriaTicketRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->categoriaTicketRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $categoriaTickets = $this->categoriaTicketRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $categoriaTickets = $this->categoriaTicketRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $categoriaTickets = $this->categoriaTicketRepository->paginate();
            }
        } else {
            $categoriaTickets = $this->categoriaTicketRepository->paginate();
        }

        return view('categoria_tickets.index', compact('title', 'breadcrumb', 'categoriaTickets', 'filters'));
    }

    /**
     * Show the form for creating a new CategoriaTicket.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Categoria de Solicitação";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addCategoriaTicket";

        return view('categoria_tickets.create', compact('title', 'breadcrumb'));
    }

    /**
     * Store a newly created CategoriaTicket in storage.
     *
     * @param CreateCategoriaTicketRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoriaTicketRequest $request)
    {
        $input = $request->all();

        $categoriaTicket = $this->categoriaTicketRepository->create($input);

        Flash::success('Categoria Ticket salvo com sucesso.');

        return redirect(route('categoriaTickets.index'));
    }

    /**
     * Display the specified CategoriaTicket.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Categoria Ticket";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showCategoriaTicket";
        
        $categoriaTicket = $this->categoriaTicketRepository->findWithoutFail($id);

        if (empty($categoriaTicket)) {
            Flash::error('Categoria Ticket não encontrado');

            return redirect(route('categoriaTickets.index'));
        }

        return view('categoria_tickets.show', compact('title', 'breadcrumb', 'categoriaTicket'));
    }

    /**
     * Show the form for editing the specified CategoriaTicket.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoriaTicket = $this->categoriaTicketRepository->findWithoutFail($id);

        if (empty($categoriaTicket)) {
            Flash::error('Categoria Ticket não encontrado');

            return redirect(route('categoriaTickets.index'));
        }

        // Titulo da página
        $title = "Categoria de Solicitação";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editCategoriaTicket";
        $breadcrumb->id = $categoriaTicket->id;
        $breadcrumb->titulo = $categoriaTicket->id;

        return view('categoria_tickets.edit', compact('title', 'breadcrumb', 'categoriaTicket'));
    }

    /**
     * Update the specified CategoriaTicket in storage.
     *
     * @param  int              $id
     * @param UpdateCategoriaTicketRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoriaTicketRequest $request)
    {
        $categoriaTicket = $this->categoriaTicketRepository->findWithoutFail($id);

        if (empty($categoriaTicket)) {
            Flash::error('Categoria Ticket não encontrado');

            return redirect(route('categoriaTickets.index'));
        }

        $categoriaTicket = $this->categoriaTicketRepository->update($request->all(), $id);

        Flash::success('Categoria Ticket atualizado com sucesso.');

        return redirect(route('categoriaTickets.index'));
    }

    /**
     * Remove the specified CategoriaTicket from storage.
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
            $itensProibidos = "";
            foreach ($ids as $id) {
                $categoriaTicket = CategoriaTicket::find($id);
                $tickets = Ticket::where('category_id',$id)->get();
                if(count($tickets) == 0 ){
                    $this->categoriaTicketRepository->delete($id);
                } else{
                    $itensProibidos .= $categoriaTicket->descricao.",";
                }
            }

            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('As categoria(s): "'.$itensProibidos. '" não podem ser inativadas porque são utilizadas em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }




            DB::commit();
            Flash::success('Categoria Ticket(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Categoria Ticket(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
