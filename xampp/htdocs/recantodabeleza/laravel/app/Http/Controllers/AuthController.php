<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest; 
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function _construct(){
    }

    public function indexEmployee(){
        return view('indexEmployee');
    }

    public function dashboard(){ 
        if(Auth::check() === true){ // caso usuario logado
           return view('index');
        }
        return redirect()->route('adm.login'); // caso nao logado 
    }

    public function showLoginForm(){   
        return view('auth.login'); 
    }

    //FAZER VALIDACAO LOGIN
    public function login(UserRequest $request){
        
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) { 
            return redirect()->route('adm'); 
        }
        return redirect()->back()->withInput()->withErrors(['ERRO' => 'E-mail ou senha inválidos!']);
    }

    public function logout(){ 
        Auth::logout();
        return redirect()->route('adm'); 
    }
}
