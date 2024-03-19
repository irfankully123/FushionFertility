<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class WebHomeController extends Controller
{

    public function index(): View
    {
        $doctors = Doctor::leftJoinSub(function ($query) {
            $query->from('ratings')
                ->select('doctor_id', DB::raw('ROUND(AVG(rating)) as avg_rating, COUNT(DISTINCT patient_id) as patient_count'))
                ->groupBy('doctor_id')
                ->orderByDesc('avg_rating')
                ->limit(5);
        }, 'ratings', function ($join) {
            $join->on('doctors.id', '=', 'ratings.doctor_id');
        })
            ->orderByDesc('ratings.avg_rating')
            ->get();
        return view('web.Pages.home', compact('doctors'));
    }

    public function doctorOverview(Doctor $doctor): View
    {
        $rating = DB::table('ratings')
            ->select(DB::raw('ROUND(AVG(rating)) as avg_rating, COUNT(DISTINCT patient_id) as patient_count'))
            ->where('doctor_id', $doctor->id)
            ->groupBy('doctor_id')
            ->first();

        if ($rating) {
            $ratingValue = $rating->avg_rating;
            $ratingCount = $rating->patient_count;
        } else {
            $ratingValue = 0;
            $ratingCount = 0;
        }

        return view('web.Pages.doctor_overview', ['doctor' => $doctor, 'rating' => $ratingValue, 'ratingCount' => $ratingCount]);
    }

}
