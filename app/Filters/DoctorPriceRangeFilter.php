<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class DoctorPriceRangeFilter
{
    public function __invoke(Builder $query, Closure $next)
    {
        $priceFrom = request()->input('price_from');
        $priceTo = request()->input('price_to');

        if ($priceFrom && $priceTo) {
            $query->whereBetween('fee', [$priceFrom, $priceTo]);
        }

        return $next($query);
    }
}
