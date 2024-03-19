<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DoctorWithRating
{
    public function handle(Builder $query, Closure $next)
    {
        return $next(static::withRating($query));
    }

    public static function withRating(Builder $query): Builder
    {
        $query->with(['ratings' => function ($query) {
            $query->select(
                'doctor_id',
                DB::raw('ROUND(AVG(rating)) as avg_rating'),
                DB::raw('COUNT(DISTINCT patient_id) as patient_count')
            )->groupBy('doctor_id');
        }]);

        $subQuery = DB::table('ratings')
            ->select('doctor_id', DB::raw('ROUND(AVG(rating)) as avg_rating'))
            ->groupBy('doctor_id')
            ->orderByDesc('avg_rating')
            ->limit(1);

        $query->leftJoinSub($subQuery, 'highest_rating', function ($join) {
            $join->on('doctors.id', '=', 'highest_rating.doctor_id');
        });

        $query->orderByDesc('highest_rating.avg_rating')->select('doctors.*');

        return $query;
    }
}
