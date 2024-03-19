<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ZoomAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'account_id',
        'client_id',
        'client_secret'
    ];
}
