<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data =['product_name'=>null,'section_name'=>null];
          $data =[];
          $i=0;
        $products = Product::all();
        foreach ($products as $product)
        {
            $data[$i] ['product_name'] = $product->product_name;
            $data[$i]['section_name']= $product->section->section_name;
            $data[$i]['description']= $product->description;
            $i++;

        }
        return $data;
        //return ['product_name'=>$products->product->name,'Section_name'=>$products->section->section_name];
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
    public function store(StoreProductRequest $request)
    {
         Product::create([
             'product_name'=>$request->product_name,
             'description'=>$request->description,
             'section_id'=>$request->section_id,
         ]);
        session()->flash('Add','The Product has been added successfully ');
        return ['Add : The Product has been added successfully '];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'product_name'=>'required|max:255',
            'description'=>'nullable|max:255',
            'section_id'=>'required',
            'id'=>'required'
        ]);
        $id = $request->id;
        $product =Product::find($id);
        $product->product_name = $request->product_name;
        $product->description = $request->description;
        $product->section_id = $request->section_id;
        $product->update();
        session()->flash('Update','The Product has been Update successfully ');
        return ['Update : The Product s been Update successfully '];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {     $this->validate($request,[
        'id'=>'required'
    ]);
        $id =$request->id;
        Product::find($id)->delete();
        session()->flash('Delete','The Product has been Delete successfully ');
        return ['Delete : The Product has been Delete successfully '];
    }
}
