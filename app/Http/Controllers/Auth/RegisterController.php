<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $clientes;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->clientes= new Cliente();
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'edad' => ['required', 'string', 'max:15'],
            'telefono' => ['required', 'string', 'max:20'],
            'apellidos' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
       // return "cumplido todo";
        $usuario = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ])->assignRole('Cliente');
        $usuario->save();
        $id=$usuario->id;
       /* $cliente=clientes::create([
            'nombre'=> $data['name'],
            'apellidos'=> $data['apellidos'],
            'edad'=> $data['edad'],
            'telefono'=> $data['telefono'],
            'id_usuario'=> $id,
        ]);*/
        $cliente=$this->clientes;
        $cliente->nombre=$data['name'];
        $cliente->apellidos=$data['apellidos'];
        $cliente->edad=$data['edad'];
        $cliente->telefono=$data['telefono'];
        $cliente->id_usuario=$id;


        /*
        clientes::create([
          //  'nombre' => 'diego22',
            'apellidos' => 'ortunio 222veisaga',
            'edad' => '212',
            'telefono' => '7222',
            'id_usuario'=>$id,
        ]);*/

       
        $cliente->save();

        return $usuario;

    }
}
