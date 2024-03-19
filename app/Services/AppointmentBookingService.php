<?php

namespace App\Services;


use App\Events\AppointmentCreatedEvent;
use App\Http\Requests\PostAppointmentRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use DateTimeZone;
use DateTime;
use Exception;

class AppointmentBookingService
{
    private Doctor $doctor;
    private string $clientTimezone;

    public function __construct(Doctor $doctor, string $clientTimezone)
    {
        $this->doctor = $doctor;
        $this->clientTimezone = $clientTimezone;
    }

    /**
     * @throws Exception
     */
    private function doctorScheduleTiming(): array
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $timings = [];

        foreach ($days as $day) {
            try {
                $schedule = $this->doctor->schedules()->where('day', $day)->first();
                $timing = null;

                if ($schedule) {
                    $timeFrom = explode(':', $schedule->time_from);
                    $timeTo = explode(':', $schedule->time_to);

                    $timing = [
                        'timeFrom' => $timeFrom[0] . ':' . $timeFrom[1],
                        'timeTo' => $timeTo[0] . ':' . $timeTo[1],
                    ];
                }

                $timings[$day] = $timing;
            } catch (Exception $exception) {
                if (config('app.env') === 'local') {
                    throw $exception;
                }
            }
        }
        return $timings;
    }

    /**
     * @throws Exception
     */
    public function generateTimeSlots(): array
    {
        $timeSlots = $this->initializeTimeSlots();
        $currentDay = date('l');
        $currentDateTime = new DateTime('now', new DateTimeZone(config('app.timezone')));
        $timings = $this->doctorScheduleTiming();

        foreach ($timings as $day => $timing) {
            $slots = $this->generateSlots($timing);
            $filteredSlots = $this->filterSlots($slots, $currentDay, $currentDateTime, $day);
            $timeSlots[$day] = $filteredSlots;
        }

        return $timeSlots;
    }

    private function initializeTimeSlots(): array
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return array_fill_keys($days, []);
    }

    private function generateSlots(array $timing): array
    {
        $consultantTiming = (int)$this->doctor->consultant_meeting_time;
        $consultantTimingDiff = 60 - $consultantTiming;
        $slots = [];

        if (isset($timing['timeFrom']) && isset($timing['timeTo'])) {
            $timeFrom = explode(':', $timing['timeFrom']);
            $timeTo = explode(':', $timing['timeTo']);

            for ($i = (int)$timeFrom[0]; $i <= (int)$timeTo[0]; $i++) {
                for ($j = 0; $j <= $consultantTimingDiff; $j += $consultantTiming) {
                    $time = sprintf('%02d:%02d', $i, $j);
                    $slots[] = $time;
                }
            }
        }

        return $slots;
    }

    /**
     * @throws Exception
     */
    private function filterSlots(array $slots, string $currentDay, DateTime $currentDateTime, string $day): array
    {
        $filteredSlots = [];
        $clientTimezone = new DateTimeZone($this->clientTimezone);
        $serverTimezone = new DateTimeZone(config('app.timezone'));

        foreach ($slots as $slot) {
            $serverDateTime = new DateTime($slot, $serverTimezone);
            $clientDateTime = clone $serverDateTime;
            $clientDateTime->setTimezone($clientTimezone);
            $formattedTime = $clientDateTime->format('h:i A');

            if ($currentDay === $day) {
                $timeDiff = $serverDateTime->getTimestamp() - $currentDateTime->getTimestamp();
                $minutesDiff = round($timeDiff / 60);

                if ($minutesDiff < 15) {
                    continue;
                }
            }

            $filteredSlots[] = $formattedTime;
        }

        return $filteredSlots;
    }


    public function doctorAppointments(): array
    {
        $appointments = [];

        $patientAppointments = $this->doctor->appointments()
            ->whereIn('status', ['Paid', 'Meeting'])
            ->get();

        foreach ($patientAppointments as $appointment) {
            $appointmentTime = explode(':', $appointment->appointment_time);
            $hour = $appointmentTime[0];
            $minutes = $appointmentTime[1];
            $formattedHour = ($hour % 12 === 0) ? 12 : $hour % 12;
            $period = ($hour < 12) ? 'AM' : 'PM';

            $date = $appointment->appointment_date;
            $formattedDate = Carbon::createFromFormat('Y-m-d', $date, config('app.timezone'))
                ->setTimezone(config('app.timezone'))
                ->format('n/j/Y');

            $appointments[] = [
                'appointment_time' => $formattedHour . ':' . $minutes . ' ' . $period,
                'appointment_date' => $formattedDate
            ];
        }

        return $appointments;
    }

    /**
     * @throws Exception
     */
    private function timeFormat(string $appointment_time): string
    {
        $timeRequest = explode(' ', $appointment_time);

        $time = $timeRequest[0];
        $timePeriod = $timeRequest[1];

        // Extract hours and minutes from the time string
        $timeParts = explode(':', $time);
        $hours = intval($timeParts[0]);
        $minutes = intval($timeParts[1]);

        // Convert to 24-hour format
        if (strtolower($timePeriod) === 'pm' && $hours != 12) {
            $hours += 12;
        } elseif (strtolower($timePeriod) === 'am' && $hours == 12) {
            $hours = 0;
        }

        // Format the time in 24-hour format
        $timeIn24HourFormat = sprintf('%02d:%02d:00', $hours, $minutes);

        // Convert to the server's timezone
        $clientTimezone = new DateTimeZone($this->clientTimezone);
        $serverTimezone = new DateTimeZone(config('app.timezone'));
        $dateTime = new DateTime($timeIn24HourFormat, $clientTimezone);
        $dateTime->setTimezone($serverTimezone);

        return $dateTime->format('H:i:s');
    }


    private function dateFormat(string $date): string
    {
        return Carbon::createFromFormat('m/d/Y', $date, config('app.timezone'))
            ->setTimezone(config('app.timezone'))
            ->format('Y-m-d');
    }

    /**
     * @throws Exception
     */
    #[ArrayShape(['join_url' => "mixed", 'start_url' => "mixed"])]
    private function createZoomMeeting(string $dateTime): array
    {
        $zoomAccess = $this->doctor->zoomAccess()->first();

        $accountID = $zoomAccess->account_id;

        $clientID = $zoomAccess->client_id;

        $client_secret = $zoomAccess->client_secret;

        $consultant_meeting_time = $this->doctor->consultant_meeting_time + 5; //5 minutes more as a threshold time in Zoom meeting duration

        $zoomApiResponse = (new ZoomCreateMeetingService())->createMeeting($dateTime, $consultant_meeting_time, $accountID, $clientID, $client_secret);

        $decodedJson = json_decode($zoomApiResponse->getContent());

        return ['join_url' => $decodedJson->join_url, 'start_url' => $decodedJson->start_url];
    }


    private function getPatientId(): int
    {
        return Auth::user()->patient()->first()->id;
    }


    #[ArrayShape(['doctor_id' => "mixed", 'amount' => "mixed", 'appointment_date' => "string", 'appointment_time' => "string", 'day' => "string", 'appointment_reason' => "string", 'zoom_start_url' => "mixed", 'zoom_join_url' => "mixed"])]
    private function buildAppointmentData(string $appointmentDate, string $appointmentTime, string $day, string $reason, array $zoom_meeting_url): array
    {
        return [
            'doctor_id' => $this->doctor->id,
            'amount' => $this->doctor->fee,
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
            'day' => $day,
            'appointment_reason' => $reason,
            'zoom_start_url' => $zoom_meeting_url['start_url'],
            'zoom_join_url' => $zoom_meeting_url['join_url'],
        ];
    }

    /**
     * @throws Exception
     */
    private function storeAsAppointment(string $appointmentDate, string $appointmentTime, string $day, string $reason, array $zoom_meeting_url): Appointment|bool
    {
        try {
            return DB::transaction(function () use ($appointmentDate, $appointmentTime, $day, $reason, $zoom_meeting_url) {
                $patientId = $this->getPatientId();
                $appointmentData = $this->buildAppointmentData($appointmentDate, $appointmentTime, $day, $reason, $zoom_meeting_url);
                return Appointment::create(array_merge($appointmentData, ['patient_id' => $patientId]));
            });
        } catch (Exception $exception) {
            if (config('app.env') === 'local') {
                throw $exception;
            }
            return false;
        }
    }

    private function updateAppointmentPrescription(Appointment $appointment, PostAppointmentRequest $request): void
    {

        if ($request->filled('prescriptionDescription')) {
            $appointment->forceFill(['prescription_description' => $request->input('prescriptionDescription')])->save();
        }

        if ($request->hasFile('prescriptionImage')) {
            $imagePath = Storage::disk('prescription')->put($appointment->id, $request->file('prescriptionImage'));
            $appointment->forceFill(['prescription_image_url' => $imagePath])->save();
        }

        if ($request->hasFile('prescriptionPdf')) {
            $pdfPath = Storage::disk('prescription')->put($appointment->id, $request->file('prescriptionPdf'));
            $appointment->forceFill(['prescription_pdf_url' => $pdfPath])->save();
        }
    }

    private function triggerAppointmentCreatedEvent(Appointment $appointment): void
    {
        $appointment->load(['patient.user']);
        $doctorUserId = $appointment->doctor->user->id;
        event(new AppointmentCreatedEvent($appointment, $doctorUserId));
    }

    /**
     * @throws Exception
     */
    public function createAppointment(PostAppointmentRequest $request): void
    {
        DB::beginTransaction();

        try {
            $appointmentDate = $this->dateFormat($request->input('appointment_date'));
            $appointmentTime = $this->timeFormat($request->input('appointment_time'));
            $dateTime = $appointmentDate . 'T' . $appointmentTime . 'Z';

            $zoom_meeting_url = $this->createZoomMeeting($dateTime);
            $day = $request->input('day');
            $reason = $request->input('appointment_reason');

            $appointment = $this->storeAsAppointment($appointmentDate, $appointmentTime, $day, $reason, $zoom_meeting_url);

            $this->updateAppointmentPrescription($appointment, $request);

            $this->triggerAppointmentCreatedEvent($appointment);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            if (config('app.env') === 'local') {
                throw $exception;
            }
        }
    }


}
