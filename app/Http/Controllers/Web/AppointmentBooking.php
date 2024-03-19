<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostAppointmentRequest;
use App\Models\Doctor;
use App\Models\Rating;
use App\Services\AppointmentBookingService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppointmentBooking extends Controller
{

    public function __construct()
    {
        $this->middleware('role:patient');
    }

    /**
     * @throws Exception
     */
    public function index(Doctor $doctor): View
    {
        $clientTimezone = session('timeZone');

        $appointmentBookingService = new AppointmentBookingService($doctor,$clientTimezone);

        $appointments = $appointmentBookingService->doctorAppointments();

        $timeSlots=$appointmentBookingService->generateTimeSlots();

        $rating = Rating::where('doctor_id', $doctor->id)
            ->selectRaw('ROUND(AVG(rating)) as avg_rating, COUNT(DISTINCT patient_id) as patient_count')
            ->groupBy('doctor_id')
            ->first();

        $ratingValue = $rating->avg_rating ?? 0;

        $ratingCount = $rating->patient_count ?? 0;

        return view('web.Pages.appointment_booking', compact('doctor', 'timeSlots', 'appointments','clientTimezone','ratingValue','ratingCount'));
    }

    /**
     * @throws Exception
     */
    public function booking(Doctor $doctor, PostAppointmentRequest $request): RedirectResponse
    {
        $clientTimezone = session('timeZone');

        $appointmentService = new AppointmentBookingService($doctor, $clientTimezone);

        $timeSlots = $appointmentService->generateTimeSlots();

        $validatedData = $request->validated();

        $selectedDate = $validatedData['appointment_date'];
        $selectedTime = $validatedData['appointment_time'];

        $selectedDay = date('l', strtotime($selectedDate));

        if (in_array($selectedTime, $timeSlots[$selectedDay])) {

            $appointmentService->createAppointment($request);

            return to_route('patient.dashboard', ['user' => Auth::id()]);
        } else {
            return back()->withErrors(['time' => 'Invalid timeslot selected.']);
        }
    }




}
