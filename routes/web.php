<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\contacts\ContactsController; 
use App\Http\Controllers\client\ClientController; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//--------Auth routes-----------
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

//------------client routes (User)------
Route::get('client_dashboard', [AuthController::class, 'client_dashboard'])->name('client.dashboard');

//----------------Contacts-------
Route::get('get_Contacts', [ContactsController::class,'get_Contacts'])->name('get_Contacts');

Route::get('getById_Contacts/{id}', [ContactsController::class,'getById_Contacts'])->name('getById_Contacts');

Route::post('save_Contacts',[ContactsController::class,'save_Contacts'])->name('save_Contacts');

Route::get('deleteById_Contacts/{id}', [ContactsController::class,'deleteById_Contacts'])->name('deleteById_Contacts');

//------------Admin routes--------
Route::middleware(['auth', 'isAdmin'])->group(function () {
    
  Route::get('admin_dashboard', [AuthController::class, 'admin_dashboard'])->name('admin.dashboard');
  Route::get('get_Client', [ClientController::class,'get_Client'])->name('get_Client');

  Route::get('getById_Client/{id}', [ClientController::class,'getById_Client'])->name('getById_Client');

  Route::post('save_Client',[ClientController::class,'save_Client'])->name('save_Client');

  Route::get('deleteById_Client/{id}', [ClientController::class,'deleteById_Client'])->name('deleteById_Client');

});

  //-------export and import Contacts-----
Route::get('export', [ContactsController::class, 'export'])->name('export');
Route::post('import', [ContactsController::class, 'import'])->name('import');


