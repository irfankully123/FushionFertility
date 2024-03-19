<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostDoctorRequest;
use App\Http\Requests\PutDoctorRequest;
use App\Models\Doctor;
use App\Services\PostDoctorService;
use App\Services\PutDoctorService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DoctorController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:super|admin']);
    }


    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Doctors/DoctorIndex', [
            'doctors' => Doctor::query()
                ->whereHas('user', function ($query) {
                    $query->where('user_type', 'doctor');
                })
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('id', 'like', '%' . $search . '%')
                        ->orWhere('gender', 'like', '%' . $search . '%')
                        ->orWhere('fee', 'like', '%' . $search . '%')
                        ->orWhere('contact', 'like', '%' . $search . '%')
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
    public function store(PostDoctorRequest $request): RedirectResponse
    {
        (new PostDoctorService($request))->createDoctor();
        sleep(2);
        return to_route('dashboard.doctor');
    }


    /**
     * @throws Exception
     */
    public function update(Doctor $doctor, PutDoctorRequest $request): RedirectResponse
    {
        (new PutDoctorService($doctor, $request))->updateDoctor();
        sleep(2);
        return to_route('dashboard.doctor');
    }



    public function destroy(Doctor $doctor): void
    {
        $doctor->delete();
        $doctor->user()->delete();
    }


}
