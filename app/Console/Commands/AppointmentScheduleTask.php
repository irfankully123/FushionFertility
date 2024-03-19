<?php

namespace App\Console\Commands;

use App\Mail\DoctorAppointmentReminder;
use App\Mail\PatientAppointmentReminder;
use App\Models\Appointment;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AppointmentScheduleTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails for appointments that have passed or are slightly ahead of the current date and time';

    public function handle(): void
    {
        try {
            Log::info('Reminder task execution started');

            $currentDateTime = now();

            $appointments = Appointment::with(['patient.user', 'doctor.user'])
                ->where('status', 'Paid')
                ->where('appointment_date', '=', $currentDateTime->toDateString())
                ->whereTime('appointment_time', '<=', $currentDateTime->toTimeString())
                ->get();

            foreach ($appointments as $appointment) {
                $appointment->status = 'Meeting';
                $appointment->save();
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
        Mail::to($recipient)->send(new DoctorAppointmentReminder($appointment));
    }

    /**
     * Send a reminder email to the given recipient.
     *
     * @param $recipient
     * @param Appointment $appointment
     */
    private function sendReminderEmailToPatient($recipient, Appointment $appointment)
    {
        Mail::to($recipient)->send(new PatientAppointmentReminder($appointment));
    }


}
