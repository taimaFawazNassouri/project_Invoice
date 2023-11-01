<?php

namespace App\Http\Controllers;
use App\Models\Invoices;
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
        $numberinvoices=Invoices::count();
        $numberpaidinvoices=Invoices::where('Value_Status',1)->count();
        $numberunpaidinvoices=Invoices::where('Value_Status',2)->count();
        $numberpartiallyinvoices=Invoices::where('Value_Status',3)->count();


        $totalinvoices = Invoices::sum('Total');
        $paidinvoices =Invoices::where('Value_Status',1)->sum('Total');
        $unpaidinvoices =Invoices::where('Value_Status',2)->sum('Total');
        $partiallyinvoices =Invoices::where('Value_Status',3)->sum('Total');
        if ( $paidinvoices == 0)
         {
            $paidpercentage = 0;
         }
         else
         {
            round($paidpercentage =  $paidinvoices/ $totalinvoices*100);
         }
         if ( $unpaidinvoices == 0)
         {
            $unpaidpercentage = 0;
         }
         else
         {
           round( $unpaidpercentage =  $unpaidinvoices/ $totalinvoices*100);
         }
         if ( $partiallyinvoices == 0)
         {
            $partiallypercentage = 0;
         }
         else
         {
             round( $partiallypercentage =  $partiallyinvoices/ $totalinvoices*100 );

        }


        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Paid Invoices', 'Unpaid Invoices ','Partially Paid Invoices'])
        ->datasets([
            [
                "label" => "Paid Invoices",
                'backgroundColor' => ['#81b214'],
                'data' => [$paidpercentage]
            ],
           
            [
                "label" => "Unpaid Invoices  ",
                'backgroundColor' => ['#ec5858'],
                'data' => [$unpaidpercentage]
            ],
           
            [
                "label" => "Partially Paid Invoices",
                'backgroundColor' => ['#ff9642'],
                'data' => [$partiallypercentage]
            ]
        ])
        ->options([]);
        
        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['Unpaid Invoices', 'Paid Invoices',' Partially Paid Invoices'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$unpaidpercentage, $paidpercentage,$partiallypercentage]
                ]
            ])
            ->options([]);
        return view('home',compact('chartjs','chartjs_2','totalinvoices','paidinvoices','unpaidinvoices','partiallyinvoices','numberinvoices','numberpaidinvoices','numberunpaidinvoices','numberpartiallyinvoices'));

  
    }
}
