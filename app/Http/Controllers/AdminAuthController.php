<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class AdminAuthController extends Controller
{
    use AuthenticatesUsers;

    //
    public function index()
    {
        if(Auth::user())
        {
            return redirect('admin/dashboard');
        }
        return view('admin.auth.index2');
    }

    public function login(Request $request)
    {
        $user = User::where('email',$request['email'])->first();
        $credentials = $request->only('email', 'password');
        if($user)
        {
            if(Auth::attempt($credentials))
            {
                return redirect()->to('admin/dashboard');
            }
            else
            {
                Auth::logout();
                return redirect('admin-login');
            }
        }
        else
        {
            return redirect('admin-login');
        }
    }
}
