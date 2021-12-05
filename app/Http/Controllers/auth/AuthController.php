<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\Contacts;
use Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        //User::truncate();
        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == '1')
                {
                    return redirect()->intended('admin_dashboard')
                        ->withSuccess('You have Successfully loggedin');
                } else {
                    return redirect('get_Contacts')
                    ->withSuccess('You have Successfully loggedin');
                }
        }
        return redirect('login')->withSuccess('Invalid Credentials');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("login")->withSuccess('Great! You have Successfully loggedin');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function client_dashboard()
    {
        if(Auth::check()){
            return view('client.index');
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    public function admin_dashboard()
    {
        if(Auth::check()){
            $Todays = Contacts::where('created_at', '>=', Carbon::today())->count();

            $Week = Contacts::where('created_at','>=',Carbon::now()->subdays(7))->count();
            
            $Month = Contacts::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
            return view('admin.index',['Todays' => $Todays,
            'Week' => $Week,
            'Month' => $Month,]);
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'role' => '0',
        'password' => Hash::make($data['password'])
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return view('welcome');
    }
}
