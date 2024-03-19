<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class DoctorSearchFilter
{
    public function __invoke(Builder $query, Closure $next)
    {
        $search = request()->input('search');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('qualification', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('fee', 'like', '%' . $search . '%')
                    ->orWhereHas('specialities', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        return $next($query);
    }
}
