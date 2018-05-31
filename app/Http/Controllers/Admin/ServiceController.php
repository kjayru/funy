<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Admin;
use App\Service;
use App\Register;
use socialite;
class ServiceController extends Controller
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
         //$servicios = Service::whereNull('parent_id')->get();
         $servicios = DB::table('services')->whereNull('parent_id')->get();
        $registros = Register::where('admin_id',$user_id)->get();

        return view('admin/asociados/servicios',['usuario'=>$mirol,'servicios'=>$servicios,'registros'=>$registros]);
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
        $user_id = Auth::id();

        $this->validate($request,[
            'service' => 'required',
            'subservice' => 'required',
            'typeservice' => 'required',
            'resources' => 'required',
            'executiontime' => 'required',
            'price' => 'required|numeric',
            
        ]);

        $register = new Register;
        $register->admin_id      = $user_id; 
        $register->service_id    = $request->service;
        $register->subservice_id = $request->subservice;
        $register->typeservice   = $request->typeservice;
        $register->resources     = $request->resources;
        $register->executiontime = $request->executiontime;
        $register->price         = $request->price;

        $register->save();

        return response()->json(['rpta'=>'ok']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reg = Service::find($id);
        
        return response()->json(['categorias'=>$reg]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $register = Register::find($id);

        return response()->json(['registro'=>$register]);
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
		
        $service = Register::find($id);
		
        
        $service->service_id    = $request->service;
        $service->subservice_id = $request->subservice;
        $service->typeservice   = $request->typeservice;
        $service->resources     = $request->resources;
        $service->executiontime = $request->executiontime;
        $service->price         = $request->price;

        $service->save();
		
		return response()->json(['rpta'=>"ok"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $servicio = Register::find($id);
        $servicio->delete();

        return response()->json(['rpta'=>'ok']);
    }
    
    public function getcategory()
    {
        $user_id = Auth::id();
        $registros = Service::with('childs')->where('parent_id',NULL)->where('admin_id',$user_id)->get();
        
        $user_rol= Admin::find($user_id)->roles()->first();
        $mirol = $user_rol->name;

        return view('admin/asociados/categorias',['registros'=>$registros,'usuario'=>$mirol,'admin_id'=>$user_id]);
    }

    public function setcategory(Request $request){

        $category = new Service();
        $category->name      = $request->nombre;
        $category->admin_id  = $request->admin_id;
        if($request->parent_id==0){
            $category->parent_id = null;
        }else{
            $category->parent_id = $request->parent_id;
        }
       

        $category->save();

        return response()->json(['rpta'=>'ok']);

    }

    public function updatecategory(Request $request, $id)
    {
        $category = Service::find($id);
        $category->name     = $request->nombre;
        $category->admin_id = $request->admin_id;
        if($request->parent_id==0){
            $category->parent_id = null;
        }else{
            $category->parent_id = $request->parent_id;
        }

        $category->save();

        return response()->json(['rpta'=>'ok']);

    }

    public function borrarcat($id)
    {
        $servicio = Service::find($id);
        $servicio->delete();

        return response()->json(['rpta'=>'ok']);
    }
	
	public function estadocat(Request $request, $id)
	{
		
		$category = Service::find($id);
		$category->status = $request->estado;
		$category->save();
		
		return response()->json(['rpta'=>'ok']);
	}
	
	public function estadoparent(Request $request, $id)
	{
		
		$category = Service::where('parent_id',$id)->update(['status' => $request->estado]);
		
		
		return response()->json(['rpta'=>'ok']);
	}
	

}
