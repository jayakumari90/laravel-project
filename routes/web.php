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
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\RoleController;
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

// Route::group(['middleware' => ['role:admin']], function () {
//     Route::get('/admin', [AdminController::class, 'index']);
// });

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('can:view dashboard');


Route::group(['middleware'=>'auth'],function()
{
    
    Route::get('/home', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/role', [RoleController::class, 'list'])->name('role.list');
    Route::any('/role/add', [RoleController::class, 'add'])->name('role.add');
    Route::any('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::any('/role/update', [RoleController::class, 'update'])->name('role.update');
    Route::any('/role/update-role-status', [RoleController::class, 'updateRoleStatus'])->name('role.updateRoleStatus');
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
    Route::get('customer/import-customer', [CustomerController::class, 'importCustomer'])->name('customer.importcustomer');
    Route::post('customer/customer-import',[CustomerController::class,'import'])->name('customer.import');
    Route::any('/customer/add', [CustomerController::class, 'add'])->name('customer.add');
    Route::any('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/{id}', [CustomerController::class, 'show'])->name('customer.show');
    Route::post('/customer/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::post('/customer/update-bill', [CustomerController::class, 'updateBillingInfo'])->name('customer.updatebill');
    Route::any('/customer/notes/{id}/', [CustomerController::class, 'notes'])->name('customer.notes');
    Route::any('/customer/addnotes', [CustomerController::class, 'addNotes'])->name('customer.addnotes');
    Route::post('/customer/notes', [CustomerController::class, 'getnotes'])->name('customer.getnotes');
    Route::any('/customer/add-ticket/{id}', [CustomerController::class, 'ticket'])->name('customer.ticket');
    Route::any('/customer/store-ticket', [CustomerController::class, 'storeTicket'])->name('customer.storeTicket');
    Route::any('/customer/ticket-list/{id}', [CustomerController::class, 'ticketList'])->name('customer.ticketList');
    Route::any('/customer/update-ticket-status', [CustomerController::class, 'updateTicketStatus'])->name('customer.updateTicketStatus');
    
    Route::any('/staff', [StaffController::class, 'list'])->name('staff.list');
    Route::any('/staff/update-staff-status', [StaffController::class, 'updateStaffStatus'])->name('staff.updateStaffStatus');
    Route::any('/staff/add', [StaffController::class, 'add'])->name('staff.add');
    Route::any('/staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{id}', [StaffController::class, 'show'])->name('staff.show');
    Route::get('staff/export/{format}', [StaffController::class, 'export'])->name('staff.export');
    



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
