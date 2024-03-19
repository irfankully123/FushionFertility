<?php

namespace App\Observers;

use App\Events\AppointmentCreatedEvent;
use App\Events\AppointmentDeletedEvent;
use App\Events\AppointmentUpdatedEvent;
use App\Models\Appointment;


class AppointmentObserver
{

    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {

    }
    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment): void
    {
        $appointment->load(['patient.user']);
        event(new AppointmentUpdatedEvent($appointment, $appointment->doctor->user->id));
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        event(new AppointmentDeletedEvent($appointment->id, $appointment->doctor->user->id));
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
