<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $patient=1;
        static $doctor=1;
        return [
            'patient_id' =>1,
            'doctor_id' => 1,
            'amount' => fake()->numberBetween($min = 1000, $max = 9000),
            'appointment_date' => fake()->date,
            'appointment_time' => fake()->time,
            'appointment_reason' => fake()->sentence,
            'day'=>fake()->dayOfWeek,
            'zoom_start_url'=>fake()->url,
            'zoom_join_url'=>fake()->url,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ];
    }
}
