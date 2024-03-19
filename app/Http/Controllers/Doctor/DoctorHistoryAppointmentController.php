<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorPrescription;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DoctorHistoryAppointmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:doctor');
    }

    public function index(User $user, Request $request): Response
    {
        $appointments = $user->appointments()
            ->where('status', 'Completed');

        if ($appointments->exists()) {
            $appointments = $appointments->get()->toQuery()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('id', 'like', '%' . $search . '%')
                            ->orWhereHas('patient.user', function ($query) use ($search) {
                                $query->where('name', 'like', '%' . $search . '%')
                                    ->orWhere('email', 'like', '%' . $search . '%');
                            })
                            ->orWhere('amount', 'like', '%' . $search . '%')
                            ->orWhere('appointment_date', 'like', '%' . $search . '%')
                            ->orWhere('appointment_time', 'like', '%' . $search . '%')
                            ->orWhere('day', 'like', '%' . $search . '%')
                            ->orWhere('status', 'like', '%' . $search . '%');
                    });
                });
        }

        $appointments = $appointments
            ->with(['patient.user', 'doctor_prescription'])
            ->oldest('appointment_date')
            ->paginate(8)
            ->withQueryString();

        return Inertia::render('Doctor/DoctorCompletedAppointments', [
            'appointments' => $appointments,
            'user_id' => $user->id,
            'filters' => $request->only(['search'])
        ]);
    }

    private function pdfGenerate(DoctorPrescription $prescription ,string $patient_name, string $doctor_name): string
    {
        view()->share('prescription', [
            'patient_name' => $patient_name,
            'doctor_name' => $doctor_name,
            'date' => $prescription->date,
            'medication' => $prescription->medication,
            'dosage' => $prescription->dosage,
            'frequency' => $prescription->frequency,
            'duration' => $prescription->duration,
            'instructions' => $prescription->instructions
        ]);

        $pdf = PDF::loadView('pdf.prescription', $prescription->toArray());

        $pdf->setPaper('A4');

        $filename = sha1($prescription->id) . '.pdf';

        $path = $prescription->id . '/' . $filename;

        $pdf->save($path, 'doctor');

        return $path;

    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {

        $request->validate([
            'medication' => 'required|string|min:3|max:255',
            'dosage' => 'required|string|max:255',
            'frequency' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'instructions' => 'required|string'
        ]);

        $patient = $appointment->patient;
        $doctor = $appointment->doctor;

        $appointment->doctor_prescription->update([
            'date' => now()->toDateString(),
            'medication' => $request->input('medication'),
            'dosage' => $request->input('dosage'),
            'frequency' => $request->input('frequency'),
            'duration' => $request->input('duration'),
            'instructions' => $request->input('instructions')
        ]);

        $path = $this->pdfGenerate($appointment->doctor_prescription,$patient->user->name,$doctor->user->name);

        $appointment->doctor_prescription->forceFill([
            'pdf_url' => $path
        ])->save();


        return to_route('doctor_dashboard.appointmentsHistory', Auth::id());

    }


}
