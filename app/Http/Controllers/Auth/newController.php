<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
public function Login(Request $request){

        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect('dashboard')

                        ->withSuccess('You have Successfully loggedin');

        }

        return redirect('/')->with('success','Oppes! You have entered invalid credentials');

    

    }
    public function dashboard(){
        
        if(Auth::check()){
            
      
      $user=auth()->user();
 return view('dashboard');
        }
        return redirect('/')->with('success','Oppes! You have entered invalid credentials');
    }
    
    public function logout(){

        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}
