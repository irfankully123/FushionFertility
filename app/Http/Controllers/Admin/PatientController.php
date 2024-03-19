<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostPatientRequest;
use App\Http\Requests\PutPatientRequest;
use App\Models\Patient;
use App\Services\PostPatientService;
use App\Services\PutPatientService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super|admin']);
    }


    public function index(Request $request): Response
    {
        $search = $request->input('search');

        return Inertia::render('Admin/Patients/PatientIndex', [
            'patients' => Patient::query()
                ->whereHas('user', function ($query) {
                    $query->where('user_type', 'patient');
                })
                ->when($request, function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('id', 'like', '%' . $search . '%')
                            ->orWhere('blood_group', 'like', '%' . $search . '%')
                            ->orWhere('gender', 'like', '%' . $search . '%')
                            ->orWhere('dob', 'like', '%' . $search . '%')
                            ->orWhere('contact', 'like', '%' . $search . '%')
                            ->orWhere('address', 'like', '%' . $search . '%');
                    })
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        });
                })
                ->with('user')
                ->orderBy('id', 'desc')
                ->paginate(8)
                ->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }


    /**
     * @throws Exception
     */
    public function store(PostPatientRequest $request): RedirectResponse
    {
        (new PostPatientService($request))->createPatient();
        sleep(2);
        return to_route('dashboard.patients');
    }


    /**
     * @throws Exception
     */
    public function update(Patient $patient, PutPatientRequest $request): RedirectResponse
    {
        (new PutPatientService($patient, $request))->updatePatient();
        sleep(2);
        return to_route('dashboard.patients');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
    }

}
