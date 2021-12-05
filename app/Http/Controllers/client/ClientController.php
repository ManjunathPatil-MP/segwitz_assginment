<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use Hash;

class ClientController extends Controller
{
    public function get_Client(Request $Request)
    {
        if (Auth::check()){ 
            $role = auth()->user()->role;
           $User = User::where('role', '!=', $role)->get();
        }elseif (Auth::check() && auth()->user()->role == 1) {
            $User = User::where('role', '=', auth()->user()->role)->get();
        }else{
            $User = User::all();
        }
        if ($Request->wantsJson()) {
            return response()->json(['code' => '200','User'=> $User]);
        }
        return view('admin.clients',['User' => $User]);
      
    }
    public function getById_Client(Request $Request,$id)
    {
        $User = User::find($id);
        if ($Request->wantsJson()) {
            return response()->json(['code' => '200','User'=> $User]);
        }
        return view('admin.clients',['User' => $User]);
       
    }
    public function save_Client(Request $Request)
    {
       
        $rules = [ 'name' => 'required',];
        $rules = [ 'email' => 'required',];
        $rules = [ 'password' => 'required',];
        $validator = Validator::make($Request->all(),$rules);
        if ($validator->fails()) {
            if ($Request->wantsJson()) {
                return response()->json(['code' => '422','message'=> 'The given data was invalid.']);
            }
                return redirect('admin.clients')->with('failed',"operation failed")
                ->withErrors($validator);
        }
        else{
            $data = $Request->input();
            if (isset($data['id'])){
                $User = User::find($data['id']);
            }if (empty($User)) {
                $User = new User;
            }
            if (isset($data)) {
                if (isset($data['name'])) {
                    $User->name = $data['name'];
                }else{
                    return response()->json(['code' => '422','message'=> 'Name is missing ,The given data was invalid.']);
                }
                if (isset($data['email'])) {
                    $User->email = $data['email'];
                }else {
                    return response()->json(['code' => '422','message'=> 'email missing ,The given data was invalid.']);
                }if (isset($data['password'])) {
                    $User->password = Hash::make($data['password']);
                }else {
                    return response()->json(['code' => '422','message'=> 'password missing ,The given data was invalid.']);
                }
                $User->role = '0';
                $User->save();
                if (isset($data['id'])){
                    if ($Request->wantsJson()) {
                        return response()->json(['updated ID' => $User->id,'code' => '200','message'=> 'Record Updated Successfully...']);
                    }
                    return redirect('get_Client')->with('success',"Record Updated Successfully...");
                }
                if ($Request->wantsJson()) {
                    return response()->json(['code' => '200','message'=> 'Record Inserted Successfully...']);
                }
                return redirect('get_Client')->with('success',"Record Inserted Successfully...");
              }
        }
    }
    public function deleteById_Client(Request $Request,$id)
    {
        $data = $Request->input();
        User::where('id', $id)->delete();
        if ($Request->wantsJson()) {
        return response()->json(['code' => '200','success'=> 'Record Deleted Successfully...']);
        }
        return redirect('get_Client')->with('success',"Record Deleted Successfully...");
    }
}
