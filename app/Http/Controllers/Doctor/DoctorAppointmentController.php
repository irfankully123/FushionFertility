<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;


class DoctorAppointmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:doctor');
    }

    public function index(User $user, Request $request): Response
    {
        $appointments = $user->appointments();
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
            ->with('patient.user')
            ->orderByDesc('id')
            ->paginate(8)
            ->withQueryString();

        return Inertia::render('Doctor/DoctorAllAppointments', [
            'appointments' => $appointments,
            'user_id' => $user->id,
            'filters' => $request->only(['search']),
            'doctor_id' => $user->doctor->id,
        ]);
    }


}
