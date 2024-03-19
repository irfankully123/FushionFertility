<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'invoice_number',
        'invoice_pdf',
        'total_amount'
    ];



    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
