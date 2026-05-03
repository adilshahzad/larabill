<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        // Create 100 dummy customers
        Customer::factory()->count(100)->create();
    }
}