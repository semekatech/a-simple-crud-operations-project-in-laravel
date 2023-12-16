<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Role;

class UserController extends Controller
{
   
 public function staff_users()
    {
      $users = DB::table('users')
      ->join('roles', 'users.role_id', '=', 'roles.id')
      ->select('users.*', 'roles.name as role_name') 
      ->get();
            $roles = Role::All();
            return view('users/index',['users' => $users,'roles' => $roles]);
    } 
    public function save_users(Request $request)
    {
 
      $user = User::insertGetId([
        'name' => $request->name,
        'email' => $request->email,
        'role_id'=> $request->role_id,
        'password' => Hash::make(123456),
      ]);  
       if($user){
        return redirect("staff-users");
       }
      }
   
}
