<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\CustomerController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('/home', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::any('/lead', [LeadController::class, 'list'])->name('lead.list');
    Route::any('/lead/add', [LeadController::class, 'add'])->name('lead.add');
    Route::any('/lead/store', [LeadController::class, 'store'])->name('lead.store');
    Route::get('/lead/{id}', [LeadController::class, 'show'])->name('lead.show');
    Route::get('/lead/edit/{id}', [LeadController::class, 'edit'])->name('lead.edit');
    Route::get('/lead/delete/{id}', [LeadController::class, 'delete'])->name('lead.delete');
    Route::any('/lead/update', [LeadController::class, 'update'])->name('lead.update');
    Route::any('/lead/customer/{id}', [LeadController::class, 'customer'])->name('lead.customer');
    Route::any('/lead/customer-update', [LeadController::class, 'customerUpdate'])->name('lead.customerUpdate');
    Route::any('/lead/update-lead-statuse', [LeadController::class, 'updateLeadStatus'])->name('lead.updateLeadStatus');
    Route::get('leads/export/{format}', [LeadController::class, 'export'])->name('lead.export');
    Route::get('leads/import-lead', [LeadController::class, 'importLead'])->name('lead.importlead');
    Route::post('/lead-import',[LeadController::class,'import'])->name('lead.import');
    Route::post('/lead-upload',[LeadController::class,'uploadFile'])->name('lead.uploadFile');
    Route::post('/lead-notes',[LeadController::class,'addNotes'])->name('lead.addNotes');

    Route::any('/customer', [CustomerController::class, 'list'])->name('customer.list');
    Route::get('customer/export/{format}', [CustomerController::class, 'export'])->name('customer.export');
    Route::any('/customer/add', [CustomerController::class, 'add'])->name('customer.add');
    Route::any('/customer/store', [CustomerController::class, 'store'])->name('customer.store');

   // Route::get('/lead/{id}', [LeadController::class, 'show'])->name('lead.show');
   // Route::get('/lead/edit/{id}', [LeadController::class, 'edit'])->name('lead.edit');
    



});

Auth::routes();
Route::post('/get-states', [Controller::class, 'getStates'])->name('getStates');
// -----------------------------login-------------------------------//
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

// ------------------------------ register ---------------------------------//
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register','storeUser')->name('register');    
});

// -------------------------- main dashboard ----------------------//
Route::controller(AdminController::class)->group(function () {
    Route::get('/home', [AdminController::class, 'index'])->name('admin.dashboard');
});
