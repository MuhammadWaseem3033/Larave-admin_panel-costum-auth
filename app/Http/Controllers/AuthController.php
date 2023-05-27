<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
       $cardentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email','password'))) {
            return redirect('dashboard');
        }
        return redirect('login')->withError('Your not valid Login ');
  
    }
    public function register_view()
    {
        return view('auth.register');

    } 
    public function register_user(Request $request)
    {
        $request->validate([
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
        ]);
        //  user create and save on role
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password) ,
        ]);
        // Login 
        // Auth::attempt(['email' => $email, 'password' => $password])
        if (Auth::attempt($request->only('email','password'))) {
            return redirect('dashboard');
        }
        return redirect('register')->withError('Your not Login in ');
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function logout(Request $request)
    {
        $request->Session()->flush();
        Auth::logout();
        return redirect('/');
    }
}
