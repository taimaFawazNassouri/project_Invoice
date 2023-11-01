<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InvoicesReportsController;
use App\Http\Controllers\CustomersReportsController;






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

Auth::routes();
Route::middleware(['check_user'])->group(function () {
    
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/invoices', InvoicesController::class);
Route::resource('/sections', SectionsController::class);
Route::resource('/products', ProductsController::class);
Route::resource('/InvoiceAttachments', InvoicesAttachmentsController::class);
Route::resource('Archive', ArchiveController::class);
Route::post('/delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');
Route::get('export_invoices',[InvoicesController::class, 'export']);
Route::get('/section/{id}', [InvoicesController::class, 'getProducts']);
Route::get('/edit_invoice/{id}', [InvoicesController::class, 'edit']);
Route::post('/invoices/update', [InvoicesController::class, 'update']);
Route::get('Stauts_show/{id}', [InvoicesController::class,'show'])->name('Status_show');
Route::post('/Status_Update', [InvoicesController::class, 'Status_Update'])->name('Status_Update');
Route::get('/invoiceDetails/{id}', [InvoicesDetailsController::class,'edit']);
Route::get('/View_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'open_file'] );
Route::get('/download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'get_file'] );
Route::get('/invoices_paid', [InvoicesController::class,'invoicePaid']);
Route::get('/invoices_unpaid', [InvoicesController::class,'invoiceUnPaid']);
Route::get('/invoices_partially_paid', [InvoicesController::class,'invoicePartiallyPaid']);
Route::get('/Print_invoice/{id}', [InvoicesController::class,'printInvoice']);
Route::get('/Invoices_Reports', [InvoicesReportsController::class ,'index']);
Route::get('/Customers_Reports', [CustomersReportsController::class ,'index']);
Route::post('/Search_invoices', [InvoicesReportsController::class ,'searchInvoices']);
Route::post('/Search_customers', [CustomersReportsController::class ,'searchCustomers']);
Route::get('MarkAsRead_all', [InvoicesController::class,'MarkAsRead_all'])->name('MarkAsRead_all');
Route::get('unreadNotifications_count', [InvoicesController::class ,'unreadNotifications_count'])->name('unreadNotifications_count');

Route::get('unreadNotifications',[InvoicesController::class ,'unreadNotifications'])->name('unreadNotifications');




Route::group(['middleware' => ['auth']], function() 
{
    Route::resource('roles',RoleController::class);
    Route::resource('users',UserController::class);
});







    

Route::get('/{page}', [App\Http\Controllers\AdminController::class,'index']);


});


