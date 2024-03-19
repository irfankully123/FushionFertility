<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $userID = 21;
        return [
            'user_id' => $userID++,
            'blood_group' => 'A+',
            'dob' => fake()->date,
            'age'=>20,
            'address'=>fake()->address,
            'city'=>fake()->city,
            'state'=>fake()->country(),
            'zip_code'=>fake()->randomDigit(),
            'contact'=>fake()->phoneNumber,
            'primary_care_physician'=>fake()->firstNameMale,
            'medical_history'=>fake()->sentence,
            'current_medications'=>fake()->sentence,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ];
    }
}
