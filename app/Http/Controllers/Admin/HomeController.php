<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Transaction;
use Inertia\Inertia;
use Inertia\Response;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super|admin']);
    }

    public function index(): Response
    {
        return Inertia::render('Home/AdminDashboardHome', [
            'doctors' => Doctor::count(),
            'patients' => Patient::count(),
            'appointments' => Appointment::count(),
            'transactions' => Transaction::count(),
        ]);
    }
}
