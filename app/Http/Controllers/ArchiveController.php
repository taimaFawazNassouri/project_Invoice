<?php

namespace App\Http\Controllers;
use App\Models\Invoices;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoices::onlyTrashed()->get();
        return view('invoices.archive_invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id =$request->invoice_id;
        $un_archive =Invoices::withTrashed()->where('id',$id)->restore();
        session()->flash('cansel_archive');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id= $request->invoice_id;
        $delete_invoice= Invoices::withTrashed()->where('id',$id)->first();
        $delete_invoice->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/Archive');


        
    }
}
