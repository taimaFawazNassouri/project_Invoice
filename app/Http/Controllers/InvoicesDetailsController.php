<?php

namespace App\Http\Controllers;

use App\Models\Invoices_details;
use App\Models\Invoices;
use App\Models\Invoices_attachments;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;
use File;

use Illuminate\Http\Request;


class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    
    {       

        $invoices = invoices::where('id',$id)->first();
        $details  = Invoices_details::all();
        //$details  = Invoices_details::where('id_Invoice',$id)->get();
        $attachments  = invoices_attachments::where('invoice_id',$id)->get();
        return view('invoices.invoice_details',compact('invoices','details','attachments'));
      
        
      
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = Invoices_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    // public function get_file($invoice_number,$file_name)

   // {
        //$contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        //return response()->download( $contents);
   // }


   public function get_file($invoice_number,$file_name)
   {
      $st="Attachments";
      $pathToFile = public_path($st.'/'.$invoice_number.'/'.$file_name);
      return response()->download($pathToFile);
   }
   public function open_file($invoice_number,$file_name)
   {
      $st="Attachments";
      $pathToFile = public_path($st.'/'.$invoice_number.'/'.$file_name);
      return response()->file($pathToFile);
   }


}