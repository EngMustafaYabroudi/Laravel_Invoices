<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $sections = Section::all();
       return $sections;
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
    public function store(StoreSectionRequest $request)
    {
        $section = $request->all();
 //       $is_exists = Section::where('section_name',$section['section_name'])->exists();
//        if($is_exists){
//            session()->flash('Error ','The Section Exists already ');
//            return ['Error : The Section Exists already '];
//        }
//        else {
            Section::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'Created_by'=>$request->Created_by,
            ]);
            session()->flash('Add','The Section has been added successfully ');
            return ['Add : The Section has been added successfully '];

        }

//    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request,[
            'section_name'=>'required|max:255',
            'description'=>'nullable|max:255'
        ]);
//
        $section = Section::find($id);
        $section->section_name = $request->section_name;
        $section->description = $request->description;
        $section->update();

        session()->flash('Update','The Section has been update successfully ');
        return ['Update : The Section has been Update successfully '];


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        Section::find($section)->each->delete();
        session()->flash('Delete','The Section has been Delete successfully ');
        return ['Update : The Section has been Delete successfully '];
    }
}
