<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DoctorHomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:doctor');
    }

    public function index(): Response
    {
        return Inertia::render('Home/DoctorDashboardHome');
    }

}
