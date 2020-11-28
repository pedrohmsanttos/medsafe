<?php

namespace App\Http\Controllers;

use App\Http\Requests\RedefinirSenha;
use App\Http\Requests\CreateUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Repositories\UsuarioRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Permission;
use App\Models\Checkout;
use App\Models\Cliente;
use App\Models\Usuario;
use App\Models\CommentTicket;
use App\Models\Corretor;
use App\Models\Role;
use App\Models\User;
use App\Models\Endereco;
use App\Models\GanhoNegocio;
use App\Models\Negocio;
use App\Models\Pedido;
use App\Models\Ticket;
use App\Models\Atividade;
use Response;
use DB;
use Auth;

class UsuarioController extends AppBaseController
{
    /** @var  UsuarioRepository */
    private $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepo)
    {
        $this->usuarioRepository = $usuarioRepo;
        // Set Permissions
        $this->middleware('permission:usuario_listar', ['only' => ['index']]);
        $this->middleware('permission:usuario_adicionar', ['only' => ['create', 'store']]);
        //$this->middleware('permission:usuario_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:usuario_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:usuario_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Usuario.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Usuários";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Usuario";
        /** Filtros */
        $this->usuarioRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->usuarioRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $usuarios = $this->usuarioRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $usuarios = $this->usuarioRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $usuarios = $this->usuarioRepository->paginate();
            }
        } else {
            $usuarios = $this->usuarioRepository->paginate();
        }

        return view('usuarios.index', compact('title', 'breadcrumb', 'usuarios', 'filters'));
    }

    /**
     * Show the form for creating a new Usuario.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Usuário";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addUsuario";

        $roles = Role::all();

        return view('usuarios.create', compact('title', 'breadcrumb', 'roles'));
    }

    /**
     * Store a newly created Usuario in storage.
     *
     * @param CreateUsuarioRequest $request
     *
     * @return Response
     */
    public function store(CreateUsuarioRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        try {
            $user = new User;
            $user->login       = $input['login'];
            $user->name        = $input['name'];
            $user->email       = $input['email'];
            $user->password    = $input['password'];
            $user->save();

            $user->roles()->attach($input['roles']);
        } catch (\Exception $e) {
            Flash::error('Error ao salvar usuário.');

            return redirect(route('usuarios.index'));
        }

        Flash::success('Usuario salvo com sucesso.');

        return redirect(route('usuarios.index'));
    }

    /**
     * Display the specified Usuario.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Usuário";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showUsuario";

        $usuario = $this->usuarioRepository->findWithoutFail($id);

        if (empty($usuario)) {
            Flash::error('Usuario não encontrado');

            return redirect(route('usuarios.index'));
        }

        return view('usuarios.show', compact('title', 'breadcrumb', 'usuario'));
    }

    /**
     * Show the form for editing the specified Usuario.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $usuario = User::find($id);

        if (empty($usuario)) {
            Flash::error('Usuario não encontrado');

            return redirect(route('usuarios.index'));
        } elseif (Auth::user()->id != $usuario->id && !Auth::user()->hasRole('super_user')) {
            return abort(403);
        }

        // Titulo da página
        $title = "Usuario";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editUsuario";
        $breadcrumb->id = $usuario->id;
        $breadcrumb->titulo = $usuario->name;

        $roles = Role::all();

        return view('usuarios.edit', compact('title', 'breadcrumb', 'usuario', 'roles'));
    }

    public function redefinirsenha()
    {
        return view('usuarios.redefinir_senha');
    }
    public function doRedefinirsenha(RedefinirSenha $request)
    {
        $user = Auth::user();
        $user->password = bcrypt($request->senha);
        $user->first_access = "1";
        $user->update();
        if (Auth::user()->hasRole('cliente_user')) {
            return redirect('/meuperfil');
        } else {
            return redirect('/home');
        }
    }

    /**
     * Update the specified Usuario in storage.
     *
     * @param  int              $id
     * @param UpdateUsuarioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsuarioRequest $request)
    {
        $user = User::find($id);
        $input = $request->all();

        if (empty($user)) {
            Flash::error('Usuario não encontrado');

            return redirect(route('usuarios.index'));
        } elseif (Auth::user()->id != $id && !Auth::user()->hasRole('super_user')) {
            return abort(403);
        }

        try {
            $user->login            = $input['login'];
            $user->name             = $input['name'];
            $user->email            = $input['email'];
            $user->first_access  = "1";
            if (isset($input['password']) && $input['password'] != '') {
                $input['password'] = bcrypt($input['password']);
                $user->password    = $input['password'];
            }

            $user->save();

            $user->roles()->sync($input['roles']);
        } catch (\Exception $e) {
            Flash::error('Error ao salvar usuário.');

            return redirect(route('usuarios.index'));
        }
 
        Flash::success('Usuario atualizado com sucesso.');
        if (Auth::user()->hasRole('cliente_user')) {
            return redirect(url('/meuperfil'));
        } else {
            return redirect(route('usuarios.index'));
        }
    }

    /**
     * Remove the specified Usuario from storage.
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
                $usuario = Usuario::find($id);
                $checkouts = Checkout::where('user_id',$id)->get();
                $clientes = Cliente::where('user_id',$id)->get();
                $commentTickets = CommentTicket::where('user_id',$id)->get();
                $corretores = Corretor::where('user_id',$id)->get();
                $ganhos = GanhoNegocio::where('usuario_operacao_id',$id)->get();
                $pedidos = Pedido::where('usuario_operacao_id',$id)->get();
                $tickets = Ticket::where('user_id',$id)->get();
                $negocios = Negocio::where('usuario_operacao_id',$id)->get();
                $atividades = Atividade::where('atribuido_id',$id)->get();
                $atividadesCriador = Atividade::where('criador_id',$id)->get();
                if( count($atividades ) == 0 && count($atividadesCriador ) == 0 && count($negocios ) == 0 && count($tickets ) == 0 && count($pedidos ) == 0 && count($ganhos ) == 0 && count($checkouts ) == 0 && count($clientes ) == 0 && count($commentTickets ) == 0 && count($corretores ) == 0){
                    $this->usuarioRepository->delete($id);
                } else{
                    $itensProibidos .= $usuario->name.",";
                }

            }
            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('Os Usuário(s): "'.$itensProibidos. '" não podem ser inativado(s) porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }

            DB::commit();
            Flash::success('Usuario(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Usuario(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
