<?php

namespace App\Http\Controllers\Web;

use App\Filters\DoctorDaysFilter;
use App\Filters\DoctorGenderFilter;
use App\Filters\DoctorPriceRangeFilter;
use App\Filters\DoctorSearchFilter;
use App\Filters\DoctorWithRating;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\View\View;

class DoctorListing extends Controller
{

    public function __invoke(Request $request): View
    {
        $doctors = app(Pipeline::class)
            ->send(Doctor::query())
            ->through([
                DoctorSearchFilter::class,
                DoctorDaysFilter::class,
                DoctorGenderFilter::class,
                DoctorPriceRangeFilter::class,
                function ($query, $next) {
                    return DoctorWithRating::withRating($next($query));
                },
            ])
            ->thenReturn()
            ->paginate(6)
            ->withQueryString();

        return view('web.Pages.doctors', compact('doctors'));
    }

}
