<?php

namespace App\Http\Controllers;

use App\invoice_details;
use App\Invoice;
use App\invoice_attachment;

use Illuminate\Http\Request;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $invoices=Invoice::where('id',$id)->first();

        $attachments=invoice_attachment::where('invoice_id',$id)->get();
        $details=invoice_details::where('id_Invoice',$id)->get();
      return  view('invoices.invoiceDetailes',compact('details','invoices','attachments')) ; 
    
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
     * @param  \App\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_details $invoice_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_details $invoice_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_details $invoice_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice_details $invoice_details)
    {
        //
    }
}
