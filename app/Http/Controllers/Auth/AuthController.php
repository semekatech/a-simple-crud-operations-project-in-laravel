<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Session;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        return view("auth.login");
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            // dd('LOGGED IN');
            return redirect()
                ->intended("dashboard")
                ->withSuccess("You have Successfully loggedin");
        }
        flash("Incorrect Credentials ")->error();
        return redirect("/");
    }
    public function dashboard(Request $request)
    {
        if (Auth::check()) {
            $user = auth()->user();
            $products = Product::count();
            $staff = User::count();
        return view("dashboard",compact('user','products','staff'));
    }
    return redirect("/")->withSuccess("Opps! You do not have access");
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect("/");
    }
}
