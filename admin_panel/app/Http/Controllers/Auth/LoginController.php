<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    //protected $redirectTo = '/home';
    protected function redirectTo(){
        if(auth()->user()){
            $client = new Client();
            $request = $client->post('http://127.0.0.1:3232/api/auth/login',
                array(
                    'form_params' => array(
                        'email' => auth()->user()->email,
                        'password' => "password",
                        'remember_me' => false,
                    )
                )
            );
            $response = json_decode($request->getBody(), true);
            if(array_key_exists("access_token", $response)){
                session(['token' => $response["access_token"]]);
                redirect('/')->with('success','Successfully logged in as '.auth()->user()->name);
            }
            else {
                redirect()->back()->with('error',"No such user exists");
            }
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
