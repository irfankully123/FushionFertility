<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * @method static create(array $array)
 * @method static count()
 * @method static forceCreate(array $array)
 * @method static findOrFail(int $int)
 * @property mixed $doctor
 * @property mixed $appointment_time
 * @property mixed $appointment_date
 * @property mixed $amount
 * @property mixed $id
 * @property mixed $patient
 * @property mixed $patient_prescription
 * @property mixed $doctor_prescription
 */
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'amount',
        'appointment_date',
        'appointment_time',
        'day',
        'appointment_reason',
        'zoom_start_url',
        'zoom_join_url',
        'status',
        'prescription_description',
        'prescription_image_url',
        'prescription_pdf_url'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function doctor_prescription(): HasOne
    {
        return $this->hasOne(DoctorPrescription::class);
    }


}
