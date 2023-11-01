<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Invoices_attachments extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'invoice_number',
        'file_name',
        'Created_by',
        
    ];
    
}
