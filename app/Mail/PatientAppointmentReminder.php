<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PatientAppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment;

    /**
     * Create a new message instance.
     *
     * @param  Appointment  $appointment
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }


    public function build(): PatientAppointmentReminder
    {
        $subject = 'Appointment Reminder Email';

        return $this->subject($subject)
            ->view('emails.patient_appointment_reminder')
            ->with([
                'appointment' => $this->appointment,
            ]);
    }
}
