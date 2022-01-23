<?php

namespace App\Http\Controllers;

use App\sections;
use App\Http\Requests\sectionrequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $sections=sections::all();
        return view ('sections.section',compact('sections'));
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

        //$validated = $request->validated();

        $request->validate([
            'section_name'=>'required|unique:sections',
        'description'=>'required', 
        ],


       
       [ 'section_name.required'=>'برجاء ادخال اسم القسم',

       'section_name.unique'=>'  اسم هذا القسم مسجل مسبقا,برجاء ادخال قسم اخر ',

       'description.required'=>'برجاء ادخال وصف القسم',
    ]);
        
      
        sections::create(
            [
              
              'section_name'=>$request ->section_name,
            'description'=>$request ->description,
            
            'Created_by'=>(Auth::user()->name),
         
         
            
         ]);
            return redirect()->back()->with(['success'=>'تم اضافه القسم بنجاح']);
         }
         
    

    /**
     * Display the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {

$section=sections::find($id);


//return $section;

        return view('sections.editesection',compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
       
        $request->validate([
            'section_name'=>'required|unique:sections',
        'description'=>'required', 
        ],


       
       [ 'section_name.required'=>'برجاء ادخال اسم القسم',

       'section_name.unique'=>'  اسم هذا القسم مسجل مسبقا,برجاء ادخال قسم اخر ',

       'description.required'=>'برجاء ادخال وصف القسم',
    ]);


        $id= $request->id;
        $sections = sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with(['success'=>'تم تحديث القسم بنجاح']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)

    {

      $id=$request->id;
     $section= sections::find($id) ;
     $section->delete();
     return redirect()->back()->with(['delete'=>'تم حذف القسم بنجاح']);


    }
}
