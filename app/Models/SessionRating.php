<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static forceCreate(array $array)
 * @method static where(string $string, string $string1)
 * @property mixed $doctor_id
 * @property mixed $patient_id
 */
class SessionRating extends Model
{
    use HasFactory;

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
