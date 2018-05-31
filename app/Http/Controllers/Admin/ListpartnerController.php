<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Admin;
use App\Workshop;
use App\Workshoporder;
use App\Register;
use App\Profile;

class ListpartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('admin');  
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $user_rol= Admin::find($user_id)->roles()->first();
        $mirol = $user_rol->name;
		
        $query=3;
        //$socios = Admin::with('roles','profile')->get();
		$socios = Admin::whereHas('roles',function($q) use($query){
            $q->where('role_id',$query);
        })->with('roles','profile')->get();
      // $socios = Profile::all();
		//dd($socios);
        return view('admin.super.asociados',['usuario'=>$mirol,'socios'=>$socios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $socio = Profile::find($id)->first();

        return response()->json(['socio'=>$socio]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $socio = Profile::find($id);

        $socio->tradename = $request->marca;
        $socio->contact = $request->contacto;
        $socio->email =  $request->emailcontacto;
        $socio->website = $request->website;
      
        $socio->save();

        return response()->json(['rpta'=>'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
