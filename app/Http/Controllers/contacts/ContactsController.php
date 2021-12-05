<?php

namespace App\Http\Controllers\contacts;

use App\Http\Controllers\Controller;
use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class ContactsController extends Controller
{
    public function get_Contacts(Request $Request)
    {
        if (Auth::check() && auth()->user()->role == 1) {
            $Contacts = Contacts::all();
        }
       else if (Auth::check()){ 
        $client_id = auth()->user()->id;
       $Contacts = Contacts::where('client_id', '=', $client_id)->get();
        }else{
            $Contacts = Contacts::all();
        }
        if ($Request->wantsJson()) {
            return response()->json(['code' => '200','Contacts'=> $Contacts]);
        }
        return view('client.index',['Contacts' => $Contacts]);
      
    }
    public function getById_Contacts(Request $Request,$id)
    {
        $Contacts = Contacts::find($id);
        if ($Request->wantsJson()) {
            return response()->json(['code' => '200','Contacts'=> $Contacts]);
        }
        return view('client.index',['Contacts' => $Contacts]);
       
    }
    public function save_Contacts(Request $Request)
    {
       
        $rules = [ 'name' => 'required',];
        $rules = [ 'phone' => 'required',];
        $validator = Validator::make($Request->all(),$rules);
        if ($validator->fails()) {
            if ($Request->wantsJson()) {
                return response()->json(['code' => '422','message'=> 'The given data was invalid.']);
            }
                return redirect('client.index')->with('failed',"operation failed")
                ->withErrors($validator);
        }
        else{
            $data = $Request->input();
            $client_id = auth()->user()->id;
            if (isset($data['id'])){
                $Contacts = Contacts::find($data['id']);
            }if (empty($Contacts)) {
                $Contacts = new Contacts;
            }
            if (isset($data)) {
                if (isset($data['name'])) {
                    $Contacts->name = $data['name'];
                }else{
                    return response()->json(['code' => '422','message'=> 'Name is missing ,The given data was invalid.']);
                }
                if (isset($data['phone'])) {
                    $Contacts->phone = $data['phone'];
                }else {
                    return response()->json(['code' => '422','message'=> 'phone missing ,The given data was invalid.']);
                }if (isset($client_id)) {
                    $Contacts->client_id = $client_id;
                }
                $Contacts->save();
                if (isset($data['id'])){
                    if ($Request->wantsJson()) {
                        return response()->json(['updated ID' => $Contacts->id,'code' => '200','message'=> 'Record Updated Successfully...']);
                    }
                    return redirect('get_Contacts')->with('success',"Record Updated Successfully...");
                }
                if ($Request->wantsJson()) {
                    return response()->json(['code' => '200','message'=> 'Record Inserted Successfully...']);
                }
                return redirect('get_Contacts')->with('success',"Record Inserted Successfully...");
              }
        }
    }
    public function deleteById_Contacts(Request $Request,$id)
    {
        $data = $Request->input();
        Contacts::where('id', $id)->delete();
        if ($Request->wantsJson()) {
        return response()->json(['code' => '200','success'=> 'Record Deleted Successfully...']);
        }
        return redirect('get_Contacts')->with('success',"Record Deleted Successfully...");
    }
    public function export() 
    {
        return Excel::download(new UsersExport, 'Contacts.xlsx');
    }
    public function import() 
    {
        Excel::import(new UsersImport,request()->file('file'));
             
        return back();
    }
}
