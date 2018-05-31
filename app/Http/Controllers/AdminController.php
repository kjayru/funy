<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Admin;
use App\Workshop;
use App\Workshoporder;
use App\Register;

class AdminController extends Controller
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
    public function index(Request $request)
    {

        $user_id  = Auth::id();
        $user_rol = Admin::find($user_id)->roles()->first();
        $mirol    = $user_rol->name;

        $request->user()->authorizeRoles(['admin','asociado','cliente']);
        if($mirol =="admin"){
           
            $numasociado = DB::table('admin_role')->where('role_id','2')->count();
            $numcliente = DB::table('admin_role')->where('role_id','3')->count();    
            $cerrados = Workshoporder::where('status','Cerrado')->count();
            $solicitados = Workshoporder::where('status','Solicitado')->count();

          
           
            return view('admin.home',[
									'usuario'      => $mirol,
									'numasociados' => $numasociado,
									'numclientes'  => $numcliente,
									'cerrados'     => $cerrados,
									'solicitados'  => $solicitados
			]);
        }
		

        if($mirol=="asociado"){
         
            return redirect()->route('profile.index',['usuario'=>$mirol]);
        }

        if($mirol=="cliente"){
            return view('admin.usuario',['usuario'=>$mirol]);
        }
         
    }
	
	
	public function estado(Request $request, $id){
		
		$admin = Admin::find($id);
		
		$admin->status = $request->estado;
		
		$admin->save();
		
		return response()->json(["rpta"=>"ok"]);
	}

}
