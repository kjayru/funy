<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Profile;
use App\Photo;
use App\Phone;
use App\Dayhour;
use App\Vacation;
use App\Admin;

class ProfileController extends Controller
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
        $usuario='asociado';
        $user_id = Auth::id();
        $profile = Profile::where('admin_id',$user_id)->first();
        $photos = Photo::where('admin_id',$user_id)->get();
        $phones = Phone::where('admin_id',$user_id)->get();
        $dias = Dayhour::where('admin_id',$user_id)->get();
        $vacaciones = Vacation::where('admin_id',$user_id)->get();
        
        return View('admin.asociados.profile',['usuario'=>$usuario,'admin_id'=>$user_id,'profile'=>$profile,'photos'=>$photos,'phones'=>$phones,'dias'=>$dias,'vacaciones'=>$vacaciones]);
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
        
/*
        $this->validate($request,[
            'tradename' => 'required',
            'contact' => 'required',
            'email' => 'required',
            'pageweb' => 'required',
            'address' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            
        ]);
*/
        $profile = new Profile;
        $profile->admin_id = $request->admin_id;
        $profile->tradename = $request->tradename;
        $profile->contact = $request->contact;
        $profile->email = $request->email;
        $profile->pageweb = $request->pageweb;
        $profile->address = $request->address;
        $profile->latitud = $request->latitud;
        $profile->longitud = $request->longitud;

        $profile->save();



        foreach ($request->file('photo') as $photo) {
            $file = $photo;
           
            $input['imagename'] = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/photos');
            $image->move($destinationPath, $input['imagename']);

            $image = new Photo();
            $image->admin_id = $request->admin_id;
            $image->name = $input['imagename'];
            $image->save();

        }

        foreach ($request->phone as $phone) {
            
            $fono = new  Phone();
            $fono->admin_id = $request->admin_id;
            $fono->phone = $phone;
            $fono->save();
        }


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
       
        $profile = Profile::where('admin_id',$id)->first();

        if ($profile === null) {         
           $profile = new Profile();
           
         }

        

        $profile->admin_id  = $request->admin_id;
        $profile->tradename = $request->tradename;
        $profile->contact   = $request->contact;
        $profile->email     = $request->email;
        $profile->website   = $request->website;
        $profile->address   = $request->address;
        $profile->latitud   = $request->latitud;
        $profile->longitud  = $request->longitud;

        $profile->save();

        $iphone = Phone::where('admin_id',$request->admin_id)->delete();

        if(count($request->file('photo'))>0){
            foreach ($request->file('photo') as $photo) {
                $file = $photo;
            
                $input['imagename'] = time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('/photos');
                $file->move($destinationPath, $input['imagename']);

                $image = new Photo();
                $image->admin_id = $request->admin_id;
                $image->name = $input['imagename'];
                $image->save();

            }
        }

        foreach ($request->phone as $phone) {
            
            $fono = new  Phone();
            $fono->admin_id = $request->admin_id;
            $fono->phone = $phone;
            $fono->save();
        }
      
       

    //diasemana
    
    Dayhour::where('admin_id',$request->admin_id)->delete();

    for($i=0;$i<7;$i++){

         $dayhour = new Dayhour();
         $dayhour->admin_id = $request->admin_id;
         $dayhour->day = $request['day'][$i];
         $dayhour->starhour = $request['apertura'][$i];
         $dayhour->endhour =  $request['cierre'][$i];
         $dayhour->save();
    }  
    //vacaciones
    Vacation::where('admin_id',$request->admin_id)->delete();

    for($j=0;$j<4;$j++){

        $vaca = new Vacation();
        $vaca->admin_id = $request->admin_id;
        $vaca->startdate = $request->vacacion[$j];
        

        $vaca->save();
    }
    
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
	
	
	public function estado(Request $request, $id){
		
		$admin = Admin::find($id);
		
		$admin->status = $request->estado;
		
		$admin->save();
		
		return response()->json(["rpta"=>"ok"]);
	}

}
