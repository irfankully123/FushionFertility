<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $id
 * @property mixed $patient
 * @property mixed $doctor
 * @property mixed $date
 * @property mixed $medication
 * @property mixed $dosage
 * @property mixed $frequency
 * @property mixed $duration
 * @property mixed $instructions
 * @method static forceCreate(array $array)
 */
class DoctorPrescription extends Model
{
    use HasFactory;

    protected $fillable=[
        'date',
        'medication',
        'dosage',
        'frequency',
        'duration',
        'instructions'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

}
