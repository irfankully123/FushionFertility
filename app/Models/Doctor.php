<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static findOrFail(mixed $input)
 * @method static where(string $string, string $string1)
 * @method paginate(int $int)
 * @method static create(array $array)
 * @method static latest()
 * @method static count()
 * @method static withCount(string $string)
 * @method static leftJoinSub(\Closure $param, string $string, \Closure $param1)
 * @property mixed $fee
 * @property mixed $id
 * @property mixed $consultant_meeting_time
 */
class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'description',
        'qualification',
        'experience',
        'dob',
        'fee',
        'rating',
        'address',
        'profile',
        'consultant_meeting_time',
        'contact'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specialities(): HasMany
    {
        return $this->hasMany(Speciality::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }


    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function patients(): HasManyThrough
    {
        return $this->hasManyThrough(Patient::class, Appointment::class, 'doctor_id', 'id', 'id', 'patient_id');
    }

    public function zoomAccess():HasOne
    {
        return $this->hasOne(ZoomAccess::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }




}
