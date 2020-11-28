<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentTicketRequest;
use App\Http\Requests\UpdateCommentTicketRequest;
use App\Repositories\CommentTicketRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use Illuminate\Support\Facades\Auth;

class CommentTicketController extends AppBaseController
{
    /** @var  CommentTicketRepository */
    private $commentTicketRepository;

    public function __construct(CommentTicketRepository $commentTicketRepo)
    {
        $this->commentTicketRepository = $commentTicketRepo;
        // Set Permissions
        // $this->middleware('permission:commentTicket_listar', ['only' => ['index']]);
        // $this->middleware('permission:commentTicket_adicionar', ['only' => ['create', 'store']]);
        // $this->middleware('permission:commentTicket_editar', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:commentTicket_deletar', ['only' => ['destroy']]);
        // $this->middleware('permission:commentTicket_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the CommentTicket.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Comment Ticket";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Comment Ticket";
        /** Filtros */
        $this->commentTicketRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->commentTicketRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $commentTickets = $this->commentTicketRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $commentTickets = $this->commentTicketRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $commentTickets = $this->commentTicketRepository->paginate();
            }
        } else {
            $commentTickets = $this->commentTicketRepository->paginate();
        }

        return view('comment_tickets.index', compact('title', 'breadcrumb', 'commentTickets', 'filters'));
    }

    /**
     * Show the form for creating a new CommentTicket.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Comment Ticket";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addCommentTicket";

        return view('comment_tickets.create', compact('title', 'breadcrumb'));
    }

    /**
     * Store a newly created CommentTicket in storage.
     *
     * @param CreateCommentTicketRequest $request
     *
     * @return Response
     */
    public function store(CreateCommentTicketRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;

        $commentTicket = $this->commentTicketRepository->create($input);
        if ($commentTicket->ticket->status == 0) {
            $commentTicket->ticket->status = 1;
            $commentTicket->ticket->save();
        } elseif (!empty($input['status'])) {
            $commentTicket->ticket->status = $input['status'];
            $commentTicket->ticket->save();
        }
        // Send e-mail
        $commentTicket->ticket->user->MensagemSolicitacao($commentTicket->ticket->id);

        Flash::success('Mensagem salva com sucesso!');

        return redirect(route('tickets.index'));
    }

    /**
     * Display the specified CommentTicket.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Comment Ticket";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showComment Ticket";
        
        $commentTicket = $this->commentTicketRepository->findWithoutFail($id);

        if (empty($commentTicket)) {
            Flash::error('Comment Ticket não encontrado');

            return redirect(route('commentTickets.index'));
        }

        return view('comment_tickets.show', compact('title', 'breadcrumb', 'commentTicket'));
    }

    /**
     * Show the form for editing the specified CommentTicket.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $commentTicket = $this->commentTicketRepository->findWithoutFail($id);

        if (empty($commentTicket)) {
            Flash::error('Comment Ticket não encontrado');

            return redirect(route('commentTickets.index'));
        }

        // Titulo da página
        $title = "Comment Ticket";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editComment Ticket";
        $breadcrumb->id = $commentTicket->id;
        $breadcrumb->titulo = $commentTicket->id;

        return view('comment_tickets.edit', compact('title', 'breadcrumb', 'commentTicket'));
    }

    /**
     * Update the specified CommentTicket in storage.
     *
     * @param  int              $id
     * @param UpdateCommentTicketRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCommentTicketRequest $request)
    {
        $commentTicket = $this->commentTicketRepository->findWithoutFail($id);

        if (empty($commentTicket)) {
            Flash::error('Comment Ticket não encontrado');

            return redirect(route('commentTickets.index'));
        }

        $commentTicket = $this->commentTicketRepository->update($request->all(), $id);

        Flash::success('Comment Ticket atualizado com sucesso.');

        return redirect(route('commentTickets.index'));
    }

    /**
     * Remove the specified CommentTicket from storage.
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
                $this->commentTicketRepository->delete($id);
            }

            DB::commit();
            Flash::success('Comment Ticket(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Comment Ticket(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
