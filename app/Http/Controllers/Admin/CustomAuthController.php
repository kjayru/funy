<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Admin;
use App\Role;
use Socialite;


class CustomAuthController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    
        //$this->middleware('auth:admin',['only'=>'redirectToProvider']);
	
		
    }
    public function showRegisterForm()
    {
        return view('custom.register');
    }

    public function register(Request $request)
    {
        $this->validation($request);
        $admin = new Admin;
        $admin->name = $request->name;
        //$admin->lastname = $request->lastname;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        
        $admin->save();
       
        $role = Role::find($request->role);
        $role->admins()->attach($admin->id);
         
        $admin->roles()->attach(Role::where('name', 'user')->first());

        return redirect('/admin/ingresar')->with('status','estas registrado');
    }

    public function showLoginForm()
    {
        return view('custom.login');
    }

    public function login(Request $request)
    {
        $this->validate($request,[
            
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ]);
        $credentials = $request->only('email','password');
       
       if (Auth::guard('admin')->attempt($credentials)) {
		   	return redirect()->intended('/admin');
        }
			return redirect('/admin')->with('status','estas registrado');
    }

    public function validation($request){
        return $this->validate($request,[
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

	public function redirectToProvider()
	{
		return Socialite::driver('google')->redirect();
	}
	
	public function handleProviderCallback()
	{
		try{
			$usersocial =  Socialite::driver('google')->user();
		}catch(Exception $e){
			return redirect('/');	
		}
		
		//$authUser = $this->findOrCreateUser($usersocial);

		//return redirect()->intended('/admin');
		
		$finduser = Admin::where('email',$usersocial->email)->first();
		
		
		if($finduser){
			$credentials = array('email'=>$finduser->email);
			
			
			//dd(Auth::guard('admin')->attempt($credentials));
			
			$credentials = array('email'=>$usersocial->email,'password'=>$usersocial->id);
       
		   if (Auth::guard('admin')->attempt($credentials)) {
				return redirect()->intended('/admin');
			}
			
		    
		
		}else{
			return view('admin.registergoogle',['usersocial'=>$usersocial]);
		}
	
			
	}
	
	/*public function findOrCreateUser($user)
	{
		$authUser = Admin::where('google_id',$user->id)->first();
		
		if($authUser){
			return $authUser;
		}

			$admin = new Admin;
			$admin->name = $user->name;

			$admin->email = $user->email;
			$admin->google_id = $user->id;

			$admin->password = bcrypt($user->id);

			$admin->save();

			$role = Role::find($user->role);
			$role->admins()->attach($admin->id);

			$admin->roles()->attach(Role::where('name', 'user')->first());
			
		return $admin;
		
		
	}
	*/
	
	public function updategoogle(Request $request){
		
	$finduser = Admin::where('email',$request->email)->first();
		
		
		if($finduser){
			
			
		$credentials = array('email'=>$finduser->email);
			
		    if (Auth::guard('admin')->attempt($credentials)) {
		   		return redirect()->intended('/admin');
        	}
			
			
			
		}else{
			
			
			$admin = new Admin;
			$admin->name = $request->name;

			$admin->email = $request->email;
			$admin->google_id = $request->google_id;

			$admin->password = bcrypt($request->google_id);

			$admin->save();

			$role = Role::find($request->role);
			
			$role->admins()->attach($admin->id);

			$admin->roles()->attach(Role::where('name', 'user')->first());

			$credentials = array('email'=>$request->email,'password'=>$request->google_id);
       
		   if (Auth::guard('admin')->attempt($credentials)) {
				return redirect()->intended('/admin');
			}
			
		}
		
	}


}
