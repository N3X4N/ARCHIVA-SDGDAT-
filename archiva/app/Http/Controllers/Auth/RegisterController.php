<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\Perfil;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
            'nombres'             => ['required', 'string', 'max:255'],
            'apellidos'           => ['required', 'string', 'max:255'],
            'email'               => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'            => ['required', 'string', 'min:8', 'confirmed'],
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
        // 1) Obtener el ID del rol "solicitante"
        $rolSolicitante = Role::where('nombre_rol', 'solicitante')
            ->firstOrFail()
            ->id;

        // 2) Crear el usuario
        $user = User::create([
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role_id'   => $rolSolicitante,
            'is_active' => true,
        ]);

        // 3) Crear el perfil asociado
        Perfil::create([
            'user_id'   => $user->id,
            'nombres'   => $data['nombres'],
            'apellidos' => $data['apellidos'],
            // 'dependencia_id' y 'firma_digital' quedan null por defecto
        ]);

        return $user;
    }
}
