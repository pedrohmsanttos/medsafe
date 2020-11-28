<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;
use Flash;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /** @var  ClienteRepository */
    private $clienteRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClienteRepository $clienteRepo)
    {
        $this->clienteRepository = $clienteRepo;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'cpfcnpj' => 'required|max:18',
            'email' => 'required|string|email|max:80|confirmed',
            'email_confirmation' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $pass    = substr(md5(uniqid(rand(), true)).md5(uniqid("")), 0, 8);
        $cliente = $this->clienteRepository->scopeQuery(function ($query) use ($data) {
            return $query->where('CNPJCPF', limpaMascara($data['cpfcnpj']))->where('email', $data['email'])->whereNull('user_id'); // Verificar se é cliente e se não tem usuário
        })->first();

        if (empty($cliente)) {
            Flash::error('Cliente não encontrado!');
            return url('/register');
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'      => $cliente->nomeFantasia,
                'email'     => $cliente->email,
                'password'  => Hash::make($pass),
                'role_current' => 'cliente_user'
            ]);

            $cliente->user_id = $user->id;
            $cliente->save();
            $user->roles()->attach(Role::where('name', 'cliente_user')->first()->id);
            $cliente->primeiroAcesso($pass);

            DB::commit();
            Flash::success('Foi enviado um e-mail com seus dados de acesso.<br> Verifique sua caixa de entrada. Caso não encontre o e-mail, favor verificar na caixa de spam.');
        } catch (Exception $e) {
            Flash::error('Não foi possivel execultar essa ação!');
            DB::rollBack();
            return url('/register');
        }

        return url('/login');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        //$this->guard()->login($user);

        return redirect($user);
    }
}
