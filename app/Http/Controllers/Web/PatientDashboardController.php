<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientProfileRequest;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class PatientDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:patient');
    }

    public function index(User $user): View
    {
        $clientTimezone = session('timeZone');

        $serverTimezone = config('app.timezone');

        $patient = $user->patient()->first();

        $appointments = $patient->appointments()
            ->where('status', 'Pending')
            ->with('doctor.user')
            ->select('id', 'patient_id', 'doctor_id','amount','appointment_date','appointment_time','appointment_reason','day','status')
            ->paginate(8);

        // Convert appointment time to client timezone
        $appointments->getCollection()->transform(function ($appointment) use ($clientTimezone, $serverTimezone) {
            $appointmentTime = Carbon::parse($appointment->appointment_time, $serverTimezone)->setTimezone($clientTimezone);
            $appointment->appointment_time = $appointmentTime->toDateTimeString();
            return $appointment;
        });

        return view('web.Pages.patient_dashboard_appointments', compact('appointments','serverTimezone','clientTimezone'));
    }


    public function storeAsPatient(PatientProfileRequest $request, User $user): RedirectResponse
    {
        $user->patient()->create($request->validated());
        return to_route('home');
    }

    private function storeAsProfile(PatientProfileRequest $request, User $user): void
    {
        $profile = $request->file('profile');
        $path = Storage::disk('users')->put($user->id, $profile);
        $user->update([
            'profile' => $path
        ]);
    }

    public function UpdateAsPatient(PatientProfileRequest $request, User $user): RedirectResponse
    {
        $patient = $user->patient()->first();
        if ($request->hasFile('profile')) {
            $this->storeAsProfile($request, $user);
        }
        $patient->update($request->validated());
        return redirect()->back();
    }


    public function scheduleAppointments(User $user): View
    {
        $clientTimezone = session('timeZone');

        $serverTimezone = config('app.timezone');

        $patient = $user->patient()->first();

        $appointments = $patient->appointments()
           ->whereIn('status', ['Paid','Meeting'])
            ->with('doctor.user')
            ->paginate(8);

        // Convert appointment time to client timezone
        $appointments->getCollection()->transform(function ($appointment) use ($clientTimezone, $serverTimezone) {
            $appointmentTime = Carbon::parse($appointment->appointment_time, $serverTimezone)->setTimezone($clientTimezone);
            $appointment->appointment_time = $appointmentTime->toDateTimeString();
            return $appointment;
        });

        return view('web.Pages.patient_dashboard_schedule_appointment', compact('appointments'));
    }

    public function AppointmentHistory(User $user): View
    {
        $clientTimezone = session('timeZone');

        $serverTimezone = config('app.timezone');

        $patient = $user->patient()->first();

        $appointments = $patient->appointments()
            ->where('status', 'Completed')
            ->with(['doctor.user','doctor_prescription'])
            ->select('id', 'patient_id', 'doctor_id','amount','appointment_date','appointment_time','appointment_reason','day','status')
            ->paginate(8);

        // Convert appointment time to client timezone
        $appointments->getCollection()->transform(function ($appointment) use ($clientTimezone, $serverTimezone) {
            $appointmentTime = Carbon::parse($appointment->appointment_time, $serverTimezone)->setTimezone($clientTimezone);
            $appointment->appointment_time = $appointmentTime->toDateTimeString();
            return $appointment;
        });

        return view('web.Pages.patient_dashboard_appointment_history', compact('appointments'));
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return to_route('patient.dashboard',['user'=>Auth::id()]);
    }

}
