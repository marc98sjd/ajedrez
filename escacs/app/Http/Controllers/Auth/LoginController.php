<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function tryLogin($email,$password){
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            do {
                $token_id = str_random(40);
            }while (User::where("remember_token", "=", $token_id)->first() instanceof User);

            DB::table('users')
            ->where('email', $email)
            ->update(['remember_token' => $token_id]);

            return "\n\nDatos correctos!\nÉste es tu token: $token_id\n\n";
        }else{
            return "\n\nLos datos introducidos no estan en nuestra base de datos.\n\n";
        }
    }

    public function logout($token){
        $user = DB::table('users')->where('remember_token', $token)->value('remember_token');
        if ($user != '') {
            DB::table('users')
            ->where('remember_token', $token)
            ->update(['remember_token' => '']);
            return "Sesión cerrada con éxito.";
        }else{
            return "No puedes cerrar sesión sin haberla abierto!";
        }
    }
}
