<?php

namespace App\Http\Controllers;

use App\invoice_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class InvoiceAttachmentController extends Controller
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
     * @param  \App\invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice_attachment $invoice_attachment)
    {
        //
    }


    public function showfile($invoice_num,$file_name){
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_num.'/'.$file_name);
        return response()->file($files);
    }

    public function downloadfile($invoice_num,$file_name){
        $contents = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_num.'/'.$file_name);
        return response()->download($contents);
    }  

    public function deletefile(Request $request){
        $attachments=invoice_attachment::find($request->id_file);
        $attachments->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        return redirect()->back()->with(['delete'=>'تم حذف المرفق بنجاح']);
    }  


}
