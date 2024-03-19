<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Speciality extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'name'
    ];
}
