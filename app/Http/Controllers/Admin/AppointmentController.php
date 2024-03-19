<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Services\ZoomCreateMeetingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super|admin']);
    }

    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Appointments/AppointmentIndex', [
            'appointments' => Appointment::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('id', 'like', '%' . $search . '%')
                        ->orWhere('amount', 'like', '%' . $search . '%')
                        ->orWhere('appointment_date', 'like', '%' . $search . '%')
                        ->orWhere('appointment_time', 'like', '%' . $search . '%')
                        ->orWhere('day', 'like', '%' . $search . '%')
                        ->orWhere('status', 'like', '%' . $search . '%')
                        ->orWhereHas('patient.user', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('doctor.user', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                })
                ->with(['patient.user', 'doctor.user'])
                ->orderBy('id', 'desc')
                ->paginate(8)
                ->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * @throws Exception
     */
    private function createAppointment(float $amount, Request $request, array $zoom_meeting_url): void
    {
        try {
            DB::beginTransaction();
            Appointment::create([
                'patient_id' => $request->input('patient_id'),
                'doctor_id' => $request->input('doctor_id'),
                'amount' => $amount,
                'appointment_date' => $request->input('date'),
                'appointment_time' => $request->input('time'),
                'appointment_reason' => $request->input('reason'),
                'zoom_start_url' => $zoom_meeting_url['start_url'],
                'zoom_join_url' => $zoom_meeting_url['join_url'],
                'day' => $request->input('day'),
                'status' => $request->input('status'),
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            if (env('PRODUCTION_ENV')) {
                throw  $exception;
            }
        }
    }

    /**
     * @throws Exception
     */
    #[ArrayShape(['join_url' => "mixed", 'start_url' => "mixed"])]
    private function createZoomMeeting(Doctor $doctor, string $dateTime): array
    {
        $zoomAccess = $doctor->zoomAccess()->first();

        $accountID = $zoomAccess->account_id;

        $clientID = $zoomAccess->client_id;

        $client_secret = $zoomAccess->client_secret;

        $consultant_meeting_time = $doctor->consultant_meeting_time + 5; //5 minutes more as a threshold time

        $zoomApiResponse = (new ZoomCreateMeetingService())->createMeeting($dateTime, $consultant_meeting_time, $accountID, $clientID, $client_secret);

        $decodedJson = json_decode($zoomApiResponse->getContent());

        return ['join_url' => $decodedJson->join_url, 'start_url' => $decodedJson->start_url];
    }

    /**
     * @throws Exception
     */
    public function store(StoreAppointmentRequest $request): void
    {

        try {
            DB::beginTransaction();
            $doctor = Doctor::findOrFail($request->input('doctor_id'));

            $amount = $doctor->fee;

            $appointmentDate = $request->input('date');

            $appointmentTime = $request->input('time');

            $dateTime = $appointmentDate . 'T' . $appointmentTime . 'Z';

            $zoom_meeting_url = $this->createZoomMeeting($doctor, $dateTime);

            if (!$zoom_meeting_url) {
                throw new NotFoundHttpException();
            }

            $this->createAppointment($amount, $request, $zoom_meeting_url);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            if (env('PRODUCTION_ENV')) {
                throw $exception;
            }
        }
    }

    /**
     * @throws Exception
     */
    public function update(Appointment $appointment, UpdateAppointmentRequest $request): void
    {
        try {
            DB::beginTransaction();
            $appointment->forceFill([
                'appointment_date' => $request->input('date'),
                'appointment_time' => $request->input('time'),
                'appointment_reason' => $request->input('reason'),
                'day' => $request->input('day'),
                'status' => $request->input('status')
            ])->save();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            if (env('PRODUCTION_ENV')) {
                throw $exception;
            }
        }
    }


    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
    }
}
