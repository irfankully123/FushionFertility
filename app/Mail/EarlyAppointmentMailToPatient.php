<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EarlyAppointmentMailToPatient extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment;

    /**
     * Create a new message instance.
     *
     * @param Appointment $appointment
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }


    public function build(): EarlyAppointmentMailToPatient
    {
        $subject = 'Appointment Reminder Email';

        return $this->subject($subject)
            ->view('emails.doctor_appointment_reminder')
            ->with([
                'appointment' => $this->appointment,
            ]);
    }
}
