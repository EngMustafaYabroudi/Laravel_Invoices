<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;

use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice_attachments $invoice_attachments)
    {
        //
    }
    public function open_file(Request $request){
        $Invoice_Number = $request->Invoice_Number;
        $file_name = $request->file_name;
        return response()->file(public_path('/Attachment/'.$Invoice_Number.'/'.$file_name));
       // return $request;
    }
    public function download_file(Request $request){

        $Invoice_Number = $request->Invoice_Number;
        $file_name = $request->file_name;
        return Storage::download(public_path('/Attachment/'.$Invoice_Number.'/'.$file_name));

    }
    public function delete_file(Request $request){
        $Invoice_Number = $request->Invoice_Number;
        $file_name = $request->file_name;
        $id=$request->id;
        $invoice_attachment = invoice_attachments::findOrFail($id);
        $invoice_attachment->delete();
        $path = public_path('Attachment/'.$Invoice_Number.'/'.$file_name);

        if(Storage::exists($path)){
            Storage::delete($path);
        }else{
           return $path;
        }
    }
}
