<?php

namespace App\Http\Controllers;
use App\sections;
use App\productes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections=sections::all();
        $productes=productes::all();

        return view('productes.productes' ,compact('sections'),compact('productes'));
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
        
        $request->validate([
            'Product_name'=>'required|unique:productes',
            'section_id'=>'required',
            //'section_name'=>'required',
        ],


       
       [ 'Product_name.required'=>'برجاء ادخال اسم المنتج',

       'Product_name.unique'=>'  اسم هذا المنتج مسجل مسبقا,برجاء ادخال منتج اخر ',

       'section_id.required'=>'رجاء ادخال رقم القسم',
       //'section_name.required'=>'رجاء ادخال اسم القسم'
    ]);


productes::create(
        [
          
          'Product_name'=>$request ->Product_name,
          'section_id'=>$request ->section_id,
        'description'=>$request ->description,
        
        
     ]);
        return redirect()->back()->with(['success'=>'تم اضافه المنتج بنجاح']);


//return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\productes  $productes
     * @return \Illuminate\Http\Response
     */
    public function show(productes $productes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\productes  $productes
     * @return \Illuminate\Http\Response
     */
    public function edit(productes $productes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\productes  $productes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
    
        $request->validate([
            'Product_name'=>'required|unique:productes',
        'section_id'=>'required'
        ],


       
       [ 'Product_name.required'=>'برجاء ادخال اسم المنتج',

       'Product_name.unique'=>'  اسم هذا المنتج مسجل مسبقا,برجاء ادخال منتج اخر ',

       
    ]);

$id= $request->pro_id;
$productes = productes::find($id);
$id_product=sections::where('section_name',$request->section_id)->first()->id;
       
        
        $productes->update([
            'Product_name' => $request->Product_name,
            'section_id'=>$id_product,
            'description' => $request->description,
        ]);

        return redirect()->back()->with(['success'=>'تم تحديث المنتج بنجاح']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\productes  $productes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
        $product=productes::find($id);
        $product->delete();
        return redirect()->back()->with(['delete'=>'تم حذف المنتج بنجاح']);

    }
public function getproduct($id){
    $product=DB::table("productes")->where("section_id",$id)->pluck("Product_name","id");
    return json_encode( $product);
}









}
