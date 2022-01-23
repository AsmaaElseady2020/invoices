<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;

class report_invoicesController extends Controller
{
    public function index(){
        return view('reports.invoice_report');
    }

    public function Search_invoices(Request $request){

        $rdio = $request->rdio;
    
    
     // في حالة البحث بنوع الفاتورة
        
        if ($rdio == 1) {
           
           
     // في حالة عدم تحديد تاريخ
            if ($request->type && $request->start_at =='' && $request->end_at =='') {
                
               $invoices = Invoice::select('*')->where('Status','=',$request->type)->get();
               $type = $request->type;
               return view('reports.invoice_report',compact('type'))->withDetails($invoices);
            }
            
            // في حالة تحديد تاريخ استحقاق
            else {
               
              $start_at = date($request->start_at);
              $end_at = date($request->end_at);
              $type = $request->type;
              
              $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status','=',$request->type)->get();
              return view('reports.invoice_report',compact('type','start_at','end_at'))->withDetails($invoices);
              
            }
    
     
            
        } 
        
    //====================================================================
        
    // في البحث برقم الفاتورة
        else {
            
            $invoices = Invoice::select('*')->where('invoice_number','=',$request->invoice_number)->get();
            return view('reports.invoice_report')->withDetails($invoices);
            
        }
    


    }








}
