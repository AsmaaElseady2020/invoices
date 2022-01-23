<?php

namespace App\Http\Controllers;
use App\Invoice;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count_all=Invoice::count();


        $paid_invoices=Invoice::where('Value_Status',1)->count();
$unpaid_invoices=Invoice::where('Value_Status',2)->count();
$partailpaid_invoices=Invoice::where('Value_Status',3)->count();





if($paid_invoices== 0){
    $invoices1=0;
}
else{
    $invoices1 =($paid_invoices/ $count_all)*100;
}

  if($unpaid_invoices == 0){
    $invoices2=0;
  }
  else{
    $invoices2 =($unpaid_invoices/ $count_all)*100;
  }

  if($partailpaid_invoices == 0){
    $invoices3=0;
  }
  else{
    $invoices3 =($partailpaid_invoices/ $count_all)*100;
  }






/*
$invoices1= ($paid_invoices/ $count_all)*100;
$invoices2= ( $unpaid_invoices/$count_all)*100;
$invoices3= ($partailpaid_invoices/ $count_all)*100;
*/




        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 300, 'height' => 200])
        ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
        ->datasets([
            [
                "label" => "الفواتير الغير المدفوعة",
                'backgroundColor' => ['#ec5858'],
                'data' => [$invoices2]
            ],
            [
                "label" => "الفواتير المدفوعة",
                'backgroundColor' => ['#81b214'],
                'data' => [$invoices1]
            ],
            [
                "label" => "الفواتير المدفوعة جزئيا",
                'backgroundColor' => ['#ff9642'],
                'data' => [$invoices3]
            ],


        ])
        ->options([]);

        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$invoices2, $invoices1,$invoices3]
                ]
            ])
            ->options([]);

        return view('home', compact('chartjs','chartjs_2'));

    }
}
