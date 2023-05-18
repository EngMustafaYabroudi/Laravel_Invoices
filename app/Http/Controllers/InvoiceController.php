<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoice_attachments;
use App\Models\invoice_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return $invoices;
    }
    public function show_archive()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return $invoices;
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

        Invoice::create([
            'Invoice_Number'=>$request->Invoice_Number,
            'Invoice_Date'=>$request->Invoice_Date,
            'Due_Date'=>$request->Due_Date,
            'Payment_Date'=>$request->Payment_Date,
            'Section_id'=>$request->Section_id,
            'Product'=>$request->Product,
            'Discount'=>$request->Discount,
            'Amount_Collection'=>$request->Amount_Collection,
            'Amount_Commission'=>$request->Amount_Commission,
            'Rate_VAT'=>$request->Rate_VAT,
            'Value_VAT'=>$request->Value_VAT,
            'Total'=>$request->Total,
            'Status'=>'Null',
            'Value_Status'=>2,
            'Note'=>$request->Note,
        ]);

        $Invoice_id = Invoice::latest()->first()->id;
        invoice_details::create([
            'Invoice_id'=>$Invoice_id,
            'Invoice_Number'=>$request->Invoice_Number,
            'Product'=>$request->Product,
            'Section'=>$request->Section_id,
            'Status'=>'Null',
            'Value_Status'=>2,
            'User'=>$request->User,
            'Note'=>$request->Note
        ]);

        if($request->hasFile('image')){
            $Invoice_id = Invoice::latest()->first()->id;
            $image =$request->file('image');
            $file_name = $image->getClientOriginalName();
            $Invoice_Number = $request->Invoice_Number;

            $attachment = new invoice_attachments();
            $attachment->file_name = $file_name;
            $attachment->Invoice_id=$Invoice_id;
            $attachment->Invoice_Number =$Invoice_Number;
            $attachment->Created_by = $request->User;
            $attachment->save();


            //
            $image->move(public_path('Attachment/'.$Invoice_Number),$file_name);

        }
        return ['Add : The Invoice has been Add successfully ',$request];


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $invoices = Invoice::findOrFail($invoice);
        $invoices->update([
            'Invoice_Number'=>$request->Invoice_Number,
            'Invoice_Date'=>$request->Invoice_Date,
            'Due_Date'=>$request->Due_Date,
            'Payment_Date'=>$request->Payment_Date,
            'Section_id'=>$request->Section_id,
            'Product'=>$request->Product,
            'Discount'=>$request->Discount,
            'Amount_Collection'=>$request->Amount_Collection,
            'Amount_Commission'=>$request->Amount_Commission,
            'Rate_VAT'=>$request->Rate_VAT,
            'Value_VAT'=>$request->Value_VAT,
            'Total'=>$request->Total,
            'Note'=>$request->Note,
        ]);
        return ['Update : The Invoice has been Update   successfully ',$request];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request,[
                       'id'=>'required'
                 ]);

        $id =$request->id;

        $Details =invoice_attachments::where('Invoice_id',$id)->first();

        if(!empty($Details->Invoice_Number)){
            $path = public_path('Attachment/'.$Details->Invoice_Number.'/'.$Details->file_name);
            Storage::delete($path);
        }
        Invoice::find($id)->forceDelete();

        session()->flash('Delete','The Invoice has been Delete successfully ');
        return ['Delete : The Invoice has been Delete successfully '];
    }

    public function move_To_archive(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);

        $id =$request->id;
        Invoice::find($id)->delete();
        session()->flash('archive','The Invoice has been archive successfully ');
        return ['archive : The Invoice has been archive successfully '];

    }
    public function move_From_archive(Request $request){

        $this->validate($request,[
            'id'=>'required'
        ]);

        $id =$request->id;
        Invoice::withoutTrashed()->where('id',$id)->restore();
        session()->flash('cancel_archive','The Invoice has been Cancel The archive successfully ');
        return [' cancel archive : The Invoice has been Cancel The archive successfully '];

    }



    public function getProducts($id){

        $states = DB::table('products')->where("section_id",$id)->pluck("product_name","id");
        return json_encode($states);

    }
    public function Status_Update(Request $request){
        $id = $request->Invoice_id;
        $invoices = Invoice::findOrFail($id);
        if($request->Status=='Paid'){
            $invoices->update([
                'Value_Status'=>1,
                'Status'=>$request->Status,
                'Payment_Date'=>$request->Payment_Date
            ]);
            invoice_details::create([
                'Invoice_id'=>$request->Invoice_id,
                'Invoice_Number'=>$request->Invoice_Number,
                'Product'=>$request->Product,
                'Section'=>$request->Section_id,
                'Status'=>$request->Status,
                'Value_Status'=>1,
                'Note'=>$request->Note,
                'Payment_Date'=>$request->Payment_id,
                'User'=>$request->User,
            ]);
        }
        else{
            $invoices->update([
                'Value_Status'=>3,
                'Status'=>$request->Status,
                'Payment_Date'=>$request->Payment_Date
            ]);
            invoice_details::create([
                'Invoice_id'=>$request->Invoice_id,
                'Invoice_Number'=>$request->Invoice_Number,
                'Product'=>$request->Product,
                'Section'=>$request->Section_id,
                'Status'=>$request->Status,
                'Value_Status'=>3,
                'Note'=>$request->Note,
                'Payment_Date'=>$request->Payment_id,
                'User'=>$request->User,
            ]);

        }
        return ['Update : The Invoice has been Update Status successfully '];

    }
    public function Invoice_Paid(){
        $invoices = Invoice::where('Value_Status',1)->get();
        return $invoices;
    }
    public function Invoice_unPaid(){
        $invoices = Invoice::where('Value_Status',2)->get();
        return $invoices;
    }
    public function Invoice_Partial(){
        $invoices = Invoice::where('Value_Status',3)->get();
        return $invoices;
    }
}
