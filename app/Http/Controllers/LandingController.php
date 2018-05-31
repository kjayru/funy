<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Province;
use App\Service;
use App\Admin;
use App\Role;
use App\Requirement;

class LandingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin',['only'=>'verificar']);
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
       //$servicios = Service::whereNull('parent_id')->get();
       $servicios = DB::table('services')
                    ->whereNull('parent_id')
		   			->where('status',2)
                    ->get();
      
       $provincias = Province::all();

       return view('landing.inicio',['servicios'=>$servicios ,'provincias'=>$provincias]);
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
        //
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
        //
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

    public function verificar(Request $request)
    {
        
       
        if(Auth::user()){
            $user_id = Auth::id();
            $user_rol= Admin::find($user_id)->roles()->first();
            $mirol = $user_rol->name;


            //$solicitud = new 
           

            $request->user()->authorizeRoles(['admin','asociado','cliente']);
            if($mirol =="admin"){
               
                $mensaje = "Solo el Cliente puede solicitar un servicio";
               
                return view('admin.home',['usuario'=>$mirol,'mensaje'=>$mensaje]);
            }

            if($mirol=="asociado"){
                
                $mensaje = "Solo el Cliente puede solicitar un servicio";
                return view('admin.asociado',['usuario'=>$mirol,'mensaje'=>$mensaje]);
            }

            if($mirol=="cliente"){
                
                $req = new Requirement();
                $req->admin_id = $user_id;
                $req->profile_id = $request->comercio_id;
                $req->state = 2;
                $req->detail ="";

                $req->save();

               
                return redirect('admin/solicitudes');

                //return view('admin.usuario',['usuario'=>$mirol]);
            }
        
        }else{
            
            return redirect('admin/ingresar');
        }
    }
}
