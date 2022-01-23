<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
class Archive_invoiceController extends Controller
{
    public function show(){

$invoices = Invoice::onlyTrashed()->get();
return view('invoices.archive_invoice',compact('invoices'));
    }

public function delete(Request $request){
    $invoices = Invoice::withTrashed()->where('id',$request->invoice_id)->first(); 
    $invoices->forceDelete();
    session()->flash('delete_invoice');
    return redirect()->back();
}
public function restore(Request $request){
    $invoices = Invoice::withTrashed()->where('id',$request->invoice_id)->restore(); 
  
    session()->flash('restore_invoice');
    return redirect()->back();
}



}
