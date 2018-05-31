<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use App\Workshop;
use App\Workshoporder;
use App\Register;
use App\Service;


class EnvironmentController extends Controller
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

        $admin = Admin::find($user_id)->first();
        $servicios = Service::with('childs')->where('parent_id',NULL)->paginate(2);

        $serviceall = Service::with('childs')->where('parent_id',NULL)->get();

        return view('admin.super.entorno',['usuario'=>$mirol,'servicios'=>$servicios,'admin_id'=>$user_id,'servall'=>$serviceall,'admin'=>$admin]);
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

        if (!(Hash::check($request->oldpassword, Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
 
        if(strcmp($request->oldpassword, $request->password) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $this->validate($request,[
            
            'email' => 'required|email|max:255',
            'oldpassword' => 'required|min:3',
            'password' => 'required|min:3',
            'npassword' => 'required|min:3|same:password'
        ],
        [
            'required' => 'Este campo es Obligatorio',
            
        ]);
        
        $user = Admin::find($id)->first();

        $admin = Admin::find($id);
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();
       
        

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


    public function updatetype(Request $request, $id)
    {

    }
}
