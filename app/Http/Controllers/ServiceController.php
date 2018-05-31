<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Service;
use Socialite;
use App\Marker;
use App\Profile;
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //$service = Service::where('parent_id',$id)->get();
        $service = DB::table('services')->where('parent_id',$id)->where('status',2)->get();

        return response()->json(['services'=>$service]);
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

    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        $admin = Socialite::driver('google')->user();

        return ($user->getAvatar());
    } 

    public function getmarker($id){
        $marker= Marker::where('province_id',$id)->first();
         
        $profiles = Profile::all();

        foreach($profiles as $key => $pro){
            $marcas[] = array('lat'=>$pro->latitud,'lng'=>$pro->longitud,
                              'name'=>$pro->tradename,'address'=>$pro->address,'id'=>$pro->id);
        }
        $marcas[] = array('lat'=>$marker->lat,'lng'=>$marker->lng,'name'=>$marker->name,'address'=>$marker->address,'id'=>'');
        
      


        return response()->json(['marker'=>$marcas]);
    }
}
