<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends Factory
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $userId = 2;
        return [
                'user_id' => $userId++,
                'gender' => 'M',
                'qualification' => fake()->sentence,
                'experience' => fake()->sentence,
                'dob' => fake()->date,
                'fee'=>fake()->numberBetween($min = 1000, $max = 9000),
                'rating' => '5',
                'is_zoom_attach'=>'1',
                'consultant_meeting_time'=>'30',
                'address' => fake()->address,
                'contact' => fake()->phoneNumber,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
        ];
    }
}
