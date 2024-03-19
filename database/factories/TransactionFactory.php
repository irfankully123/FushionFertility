<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        static $patient_id = 1;
        return [
            'patient_id'=>$patient_id++,
            'transaction_date'=>fake()->date,
            'amount'=>fake()->numberBetween($min = 1000, $max = 9000),
            'payment_method'=>'card',
            'card_brand'=>'visa',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ];
    }
}
