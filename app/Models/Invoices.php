<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'Due_date',
        'product',
        'section_id',
        'Amount_collection',
        'Amount_Commission',
        'Discount',
        'Value_VAT',
        'Rate_VAT',
        'Total',
        'Status',
        'Value_Status',
        'note',
        'Payment_Date',
    ];

    protected $dates = ['deleted_at'];
    public function section(): BelongsTo
    {
        return $this->belongsTo(Sections::class, 'section_id');
    }
    public function invoice_attachments()
    {
        return $this->belongsTo('App\Models\Invoices_attachments');
    }
    public function invoice_details()
    {
        return $this->belongsTo('App\Models\Invoices_details');
    }
   
    
    
}