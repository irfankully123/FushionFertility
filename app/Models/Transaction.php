<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property mixed $amount
 * @method static count()
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'transaction_date',
        'amount',
        'payment_method',
        'card_brand'
    ];

}
