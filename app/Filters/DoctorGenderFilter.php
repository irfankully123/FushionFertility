<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class DoctorGenderFilter
{
    public function __invoke(Builder $query, Closure $next)
    {
        $male = request()->input('male');
        $female = request()->input('female');

        if ($male) {
            $query->where('gender', 'M');
        }

        if ($female) {
            $query->where('gender', 'F');
        }

        return $next($query);
    }
}
