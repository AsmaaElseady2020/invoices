<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Invoice;
use App\sections;
use App\User;
use App\ invoice_details;
use App\invoice_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\addinvoice;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices=Invoice::all();
        return view('invoices.invoice',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections=sections::all();
        return view('invoices.createinvoice',compact('sections'));
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
        'invoice_number' => $request->invoice_number,
        'invoice_Date' => $request->invoice_Date,
        'Due_date' => $request->Due_date,
        'product' => $request->product,
        'section_id' => $request->Section,
        'Amount_collection' => $request->Amount_collection,
        'Amount_Commission' => $request->Amount_Commission,
        'Discount' => $request->Discount,
        'Value_VAT' => $request->Value_VAT,
        'Rate_VAT' => $request->Rate_VAT,
        'Total' => $request->Total,
        'Status' => 'غير مدفوعة',
        'Value_Status' => 2,
        'note' => $request->note,
    ]);

    $invoice_id = invoice::latest()->first()->id;
    invoice_details::create([
        'id_Invoice' => $invoice_id,
        'invoice_number' => $request->invoice_number,
        'product' => $request->product,
        'Section' => $request->Section,
        'Status' => 'غير مدفوعة',
        'Value_Status' => 2,
        'note' => $request->note,
        'user' => (Auth::user()->name),
    ]);

    if ($request->hasFile('pic')) {
//image
        $file_extension=$request->pic-> getClientOriginalExtension();
        $file_name=time().'.'.$file_extension;
        $invoice_id =invoice ::latest()->first()->id;
        
        $invoice_number = $request->invoice_number;
       
        //create
        invoice_attachment::create([
           'file_name'=>$file_name,
           'invoice_number'=> $invoice_number,
           'Created_by' => (Auth::user()->name),
'invoice_id'=> $invoice_id

        ]);
    
        // move pic
        $path='images/'. $invoice_number;
        $request ->pic ->move($path,$file_name);
    }

    //$user = User::first();
            //Notification::send($user, new addinvoice($invoice_id));


            $user = User::find(Auth::User()->id);
            $invoice =invoice ::latest()->first();
            Notification::send($user, new \App\Notifications\store_invoice($invoice));



    return redirect()->back()->with(['success'=>'تم اضافه الفاتوره بنجاح']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices=Invoice::where('id',$id)->first();
        return view(' invoices.status_update',compact('invoices'));

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices=Invoice::where('id',$id)->first();
        $sections= sections::all();
        return  view('invoices.editeinvoice',compact('invoices','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices=Invoice::find($request->id);
        $invoices_attachment=invoice_attachment::find($invoices->id);
        //$invoice_details=invoice_details::find($invoices->id);
        $invoices->update([

            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,

        ]);

        $invoices_attachment->update([
            'invoice_number'=> $request->invoice_number,

        ]);
        /*
        $invoice_details->update([
            'invoice_number'=> $request->invoice_number,
            'product' => $request->product,
       // 'section_id' => $request->Section,
       
           
           // 'note' => $request->note,

        ]);
*/
        return redirect()->back()->with(['success'=>'تم تحديث الفاتوره بنجاح']);


      
   
        
    }
public function update_status (Request $request,$id){
   
    $invoices = Invoice::findOrFail($id);

    if ($request->Status === 'مدفوعة') {

        $invoices->update([
            'Value_Status' => 1,
            'Status' => $request->Status,
            'Payment_Date' => $request->Payment_Date,
        ]);

        invoice_details::create([
            'id_Invoice' => $request->invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => $request->Status,
            'Value_Status' => 1,
            'note' => $request->note,
            'Payment_Date' => $request->Payment_Date,
            'user' => (Auth::user()->name),
        ]);
    }

    
else{ $invoices->update([
    'Value_Status' => 3,
    'Status' => $request->Status,
    'Payment_Date' => $request->Payment_Date,
]);

invoice_details::create([
    'id_Invoice' => $request->invoice_id,
    'invoice_number' => $request->invoice_number,
    'product' => $request->product,
    'Section' => $request->Section,
    'Status' => $request->Status,
    'Value_Status' => 3,
    'note' => $request->note,
    'Payment_Date' => $request->Payment_Date,
    'user' => (Auth::user()->name),
]);}



    session()->flash('update_invoice');
    return redirect()->back();


}





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)

    {
        $id_page =$request->id_page;
 $invoices=Invoice::where('id',$request->invoice_id)->first();

 $Details=invoice_attachment::where('invoice_id',$request->invoice_id)->first();

//if(!$id_page==2){}
        if (!empty($Details->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);}
        
$invoices->forceDelete() ;
     return redirect()->back()->with(['delete_invoice']);
       session()->flash('delete_invoice');
       return redirect()->back();
/*
       else {

        $invoices->delete();
        session()->flash('archive_invoice');
        return redirect()->back();
      }
      */
    
    }

public function archive_invoice(Request $request){
    $invoices=Invoice::where('id',$request->invoice_id)->first();

    $invoices->delete();
    session()->flash('archive_invoice');
    return redirect()->back();
}





public function Partail_invoice(){
    $invoices=Invoice::where('Value_Status',3)->get();
    return view('invoices.Partail_invoice',compact('invoices'));


}

public function Paid_invoice(){
    $invoices=Invoice::where('Value_Status',1)->get();
    return view('invoices.Paid_invoice',compact('invoices'));


} 

public function UnPaid_invoice(){
    $invoices=Invoice::where('Value_Status',2)->get();
    return view('invoices.UnPaid_invoice',compact('invoices'));


}

public function print_invoice($id){
    $invoices = Invoice::where('id', $id)->first();
    return view('invoices.Print_invoice',compact('invoices'));

     
    
}
public function export()
{

    return Excel::download(new InvoiceExport, 'invoices.xlsx');

}



public function MarkAsRead_all(Request $request)
{
    $userUnreadNotification=auth()->user()->unreadNotifications;

    if($userUnreadNotification){
        $userUnreadNotification->markAsRead(); 
    }

    return back();

}




}


