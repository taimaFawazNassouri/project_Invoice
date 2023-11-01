<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Sections;
use App\Models\Invoices;


class CustomersReportsController extends Controller
{
    public function index(){
        $sections = Sections::all();
        return view('reports.customers_reports',compact('sections'));
    
    }
    public function searchCustomers(Request $request){
        //في حالة عدم تحديد التاريخ

        if($request->Section && $request->product && $request->start_at == ''&& $request->end_at == '')
        {
            $invoices = Invoices::select('*')->where('section_id',$request->Section)->where('product',$request->product)->get();
            $sections = Sections::all();
            return view('reports.customers_reports',compact('sections'))->withDetails($invoices);

        }
        //  //في حالة تحديدالتاريخ

        // else{

        // }
        
    }


}
