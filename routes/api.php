<?php

use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Section Routes

Route::resource('section',SectionController::class)->except('update');
Route::post('section/update',[SectionController::class,'update']);

// Product Routes
Route::resource('product',ProductController::class)->except(['update','destroy']);
Route::post('product/update',[ProductController::class,'update']);
Route::delete('product',[ProductController::class,'destroy']);

// Invoices Routes

Route::get('invoice/section/{id}',[InvoiceController::class,'getProducts']);
Route::resource('invoice',InvoiceController::class)->except(['update','destroy']);
Route::post('invoice/update',[InvoiceController::class,'update']);
Route::delete('invoice',[InvoiceController::class,'destroy']);

// archive
Route::get('invoice/archive/show_archive',[InvoiceController::class,'show_archive']);
Route::delete('invoice/archive/move_To_archive',[InvoiceController::class,'move_To_archive']);
Route::post('invoice/archive/move_From_archive',[InvoiceController::class,'move_From_archive']);


//
Route::Post('invoice/Update_Status',[InvoiceController::class,'Status_Update']);
Route::get('invoice/Paid',[InvoiceController::class,'Invoice_Paid']);
Route::get('invoice/unPaid',[InvoiceController::class,'Invoice_unPaid']);
Route::get('invoice/Partial',[InvoiceController::class,'Invoice_Partial']);

// Invoice Attachment Routes

 Route::post('invoiceAttachment/open_file',[InvoiceAttachmentsController::class,'open_file']);
 Route::post('invoiceAttachment/download_file',[InvoiceAttachmentsController::class,'download_file']);
 Route::post('invoiceAttachment/delete_file',[InvoiceAttachmentsController::class,'delete_file']);
