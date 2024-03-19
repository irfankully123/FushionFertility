<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DoctorPatientsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:doctor']);
    }


    public function index(Request $request): Response
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();
        if ($doctor) {
            $search = $request->input('search');
            $patients = $doctor->patients()
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('patients.id', 'like', '%' . $search . '%')
                            ->orWhereHas('user', function ($query) use ($search) {
                                $query->where('name', 'like', '%' . $search . '%')
                                    ->orWhere('email', 'like', '%' . $search . '%');
                            })
                            ->orWhere('address', 'like', '%' . $search . '%')
                            ->orWhere('contact', 'like', '%' . $search . '%')
                            ->orWhere('state', 'like', '%' . $search . '%')
                            ->orWhere('city', 'like', '%' . $search . '%')
                            ->orWhere('zip_code', 'like', '%' . $search . '%');
                    });
                })
                ->with('user')
                ->distinct()
                ->orderBy('id', 'desc')
                ->paginate(8)
                ->withQueryString();
        } else {
            $patients = [];
        }
        return Inertia::render('Doctor/DoctorPatientsIndex', [
            'patients' => $patients,
            'filters' => $request->only(['search'])
        ]);
    }

    public function detail(Patient $patient): Response
    {
        return Inertia::render('Doctor/DoctorPatientDetails', [
            'detail' => [
                'user' => $patient->user,
                'patient' => $patient,
            ]
        ]);
    }
}
