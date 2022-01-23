<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

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
    return view('auth.register');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

#################### invoice#########################
Route::get('/invoice', 'InvoiceController@index')->name('invoice');
Route::get('/createinvoice', 'InvoiceController@create')->name('createinvoice');
Route::post('/insertinvoice','InvoiceController@store');
Route::get('/editeinvoice/{id}', 'InvoiceController@edit');
Route::post('/updateinvoice', 'InvoiceController@update')->name('updateinvoice');
Route::delete('/deleteinvoice', 'InvoiceController@destroy')->name('deleteinvoice');
Route::get('/status_show/{invoice_id}', 'InvoiceController@show')->name('Status_show');
Route::post('/update_status/{invoice_id}', 'InvoiceController@update_status')->name('Status_Update');
Route::get('/print_invoice/{invoice_id}', 'InvoiceController@print_invoice')->name('print_invoice');
Route::delete('/archive_invoice','InvoiceController@archive_invoice')->name('archive_invoice');

Route::get('/Paid_invoice', 'InvoiceController@Paid_invoice')->name('Paid_invoice');

Route::get('/UnPaid_invoice', 'InvoiceController@UnPaid_invoice')->name('UnPaid_invoice');
Route::get('/Partial_invoice', 'InvoiceController@Partail_invoice')->name('Partail_invoice');
Route::get('export_invoice', 'InvoiceController@export');
####################  archive invoice      #########################


Route::get('/show_archive_invoice', 'Archive_invoiceController@show')->name('show_archive_invoice');
Route::delete('/delete_archive_invoice','Archive_invoiceController@delete')->name('delete_archive_invoice');
Route::get('/restore_archive_invoice', 'Archive_invoiceController@restore')->name('restore_archive_invoice');


#################### invoice  Detiales    #########################
Route::get('/InvoicesDetails/{id}', 'InvoiceDetailsController@index');
#################### invoice  attachments    #########################
Route::get('/show/{invoice_num}/{file_name}', 'InvoiceAttachmentController@showfile');
Route::get('/download/{invoice_num}/{file_name}', 'InvoiceAttachmentController@downloadfile');
Route::post('/delete', 'InvoiceAttachmentController@deletefile')->name('delete_file');



###################### section  ######################## 
Route::get('/section', 'SectionsController@index');

Route::post('/store', 'SectionsController@store')->name('insertsection');

Route::get('/delete', 'SectionsController@destroy')->name('deleteSection');

Route::post('/update', 'SectionsController@update')->name('updateSection');

################### productes##################################
Route::get('/productes', 'ProductesController@index');
Route::post('/insert', 'ProductesController@store')->name('insertproduct');
Route::post('/updateproduct', 'ProductesController@update')->name('updateproduct');
Route::get('/deleteproduct', 'ProductesController@destroy')->name('deleteproduct');
Route::get('getproduct/{id}', 'ProductesController@getproduct');


//permission 

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    });


    #########################notification###########################
    

    Route::get('markasread', 'InvoiceController@MarkAsRead_all')->name('markeasRead');

######################### invoices_report###########################
Route::get('report_invoice', 'report_invoicesController@index');
Route::post('Search_invoices', 'report_invoicesController@Search_invoices');


######################### customers_report###########################
Route::get('report_customers','report_customersController@index');
Route::post('Search_customers', 'report_customersController@Search_customers');


Route::get('/{page}', 'AdminController@index');
