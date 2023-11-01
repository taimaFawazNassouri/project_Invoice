<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Products extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Sections::class, 'section_id');
    }
}
