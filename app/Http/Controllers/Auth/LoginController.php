<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

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


    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
        public function postLogin(Request $request){

        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect('dashboard')

                        ->withSuccess('You have Successfully loggedin');

        }
        return redirect("login-user")->with('success','Oppes! You have entered invalid credentials');

    

    }
    public function dashboard(){
        
        if(Auth::check()){
            return view('dashboard');
        
        }
        return redirect("login")->with('success','Oppes! You have entered invalid credentials');
    }
}
