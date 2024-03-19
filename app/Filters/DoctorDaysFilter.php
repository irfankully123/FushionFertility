<?php

namespace App\Filters;
use Closure;
use Illuminate\Database\Eloquent\Builder;


class DoctorDaysFilter
{
    public function __invoke(Builder $query, Closure $next)
    {
        $selectedDay = request()->input('days');

        if ($selectedDay && $selectedDay!=='0') {
            $query->whereHas('schedules', function ($query) use ($selectedDay) {
                $query->where('day', $selectedDay);
            });
        }

        return $next($query);
    }
}
