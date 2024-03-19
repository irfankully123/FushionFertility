<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static count()
 * @property mixed $user
 */
class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blood_group',
        'gender',
        'dob',
        'age',
        'address',
        'city',
        'state',
        'zip_code',
        'contact',
        'primary_care_physician',
        'medical_history',
        'current_medications'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
