<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CustomerInvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        static $transaction_id=1;
        return [
            'transaction_id'=>$transaction_id++,
            'invoice_number'=> fake()->creditCardNumber,
            'invoice_pdf'=>fake()->url,
            'total_amount'=>fake()->randomDigit(),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ];
    }
}
