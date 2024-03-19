<?php

namespace App\Console\Commands;

use App\Mail\EarlyAppointmentMailToDoctor;
use App\Mail\EarlyAppointmentMailToPatient;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Models\Appointment;
use Exception;

class EarlyAppointmentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:early-send-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Early Appointment Reminder for both Doctor And Patient';

    public function handle(): void
    {
        try {
            Log::info('Reminder task execution started');

            $currentDateTime = now();
            $reminderDateTime = $currentDateTime->subMinutes(30);

            $appointments = Appointment::with(['patient.user', 'doctor.user'])
                ->where('status', 'Paid')
                ->where('appointment_date', '=', $reminderDateTime->toDateString())
                ->whereTime('appointment_time', '<=', $reminderDateTime->toTimeString())
                ->get();

            foreach ($appointments as $appointment) {
                $this->sendReminderEmailToPatient($appointment->patient->user->email, $appointment);
                $this->sendReminderEmailToDoctor($appointment->doctor->user->email, $appointment);
            }

            Log::info('Reminder task executed successfully');
        } catch (Exception $e) {
            // Log task execution failure
            Log::error('Reminder task failed: ' . $e->getMessage());
        }
    }


    /**
     * Send a reminder email to the given recipient.
     *
     * @param $recipient
     * @param Appointment $appointment
     */
    private function sendReminderEmailToDoctor($recipient, Appointment $appointment)
    {
        Mail::to($recipient)->send(new EarlyAppointmentMailToDoctor($appointment));
    }

    /**
     * Send a reminder email to the given recipient.
     *
     * @param $recipient
     * @param Appointment $appointment
     */
    private function sendReminderEmailToPatient($recipient, Appointment $appointment)
    {
        Mail::to($recipient)->send(new EarlyAppointmentMailToPatient($appointment));
    }
}
