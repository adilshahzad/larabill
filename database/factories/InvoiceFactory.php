<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'invoice_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'total_amount' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}