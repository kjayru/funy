<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('usuario',['except'=>'test']);
    }


    public function index(){
        
        return view('admin.usuario');
    }

   

     /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
