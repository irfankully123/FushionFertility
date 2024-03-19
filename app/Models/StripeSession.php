<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $id)
 */
class StripeSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'stripe_session_id',
        'stripe_customer_id'
    ];




}
