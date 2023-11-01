<?php

namespace App\Http\Controllers;


use App\Models\Invoices;
use App\Models\User;
use App\Models\Invoices_details;
use App\Models\Invoices_attachments;
use App\Models\Products;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddInvoice;
use App\Notifications\sentToData;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Concerns\FromCollection;


class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Sections::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        invoices::create([
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
            'Status' => 'unpaid',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);
        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'unpaid',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);
        

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new Invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
       }
    //    $user = User::first();
    //    Notification::send($user, new AddInvoice($invoice_id));
       $user =User::get();
       $invoices = Invoices::latest()->first();
       //$user->notify(new sent_toDatabaseAddInvoice($invoices));
       Notification::send($user, new sentToData($invoices));

       session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
       return redirect('/invoices');
      
}

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $invoices = Invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }


    /**
     * Show the form for editing the specified resource.
     */
   
    public function Status_Update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);

        if ($request->Status === 'paid') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
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
        else{
            
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
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
    }
      /**
     * update status invoice
     */
    public function edit($id)
    {
        $invoices = Invoices::where('id',$id)->first();
        $sections = Sections::all();
        return view('invoices.edit_invoice',compact('invoices','sections'));
        
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices $invoices)
    {
        
        $invoices = Invoices::findOrFail($request->invoice_id);
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

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->invoice_id;
        $delete_invoice = Invoices::where('id',$id)->first();
        $delete_attachments = Invoices_attachments::where('invoice_id',$id)->first();
        $id_page = $request->id_page;
        if (!$id_page == 2) {
            if(!empty($delete_attachments->invoice_number))
            {
    
                Storage::disk('public_uploads')->deleteDirectory($delete_attachments->invoice_number);
    
    
            }
            $delete_invoice->forceDelete();
            session()->flash('delete');
            return redirect('/invoices');
           
        }
        else
        {
            $delete_invoice->delete();
            session()->flash('archive_invoice');
            return redirect('/Archive');

        }
      
    
    }
    public function export()
    {

        return Excel::download(new InvoiceExport, 'invoices.xlsx');

    }
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }
    public function invoicePaid(){
        $invoices =Invoices::where('Value_Status',1)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }
   
    public function invoiceUnPaid(){
        $invoices =Invoices::where('Value_Status',2)->get();
        return view('invoices.invoices-unpaid',compact('invoices'));
    }
    public function invoicePartiallyPaid(){
        $invoices =Invoices::where('Value_Status',3)->get();
        return view('invoices.invoices_partiallypaid',compact('invoices'));
    }
    public function printInvoice(Request $request, String $id){
        $invoices=Invoices::where('id',$id)->first();
        return view('invoices.print_invoice',compact('invoices'));
    
    }
    public function MarkAsRead_all(Request $request){
        $userUnReadNotification = auth()->user()->unreadNotifications;
        if($userUnReadNotification)
        {
            $userUnReadNotification->markAsRead();
            return back();



        }
    }
    
    public function unreadNotifications_count()

    {
        return auth()->user()->unreadNotifications->count();
    }

    public function unreadNotifications()

    {
        foreach (auth()->user()->unreadNotifications as $notification){

        return $notification->data['title'];

        }

    }

}