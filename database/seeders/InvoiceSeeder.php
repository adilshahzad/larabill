<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        // Create 200 dummy invoices
        Invoice::factory()->count(200)->create()->each(function ($invoice) {
            // Add 1-5 items to each invoice
            InvoiceItem::factory()->count(rand(1, 5))->create([
                'invoice_id' => $invoice->id,
            ]);

            // Calculate and update the total amount for the invoice
            $totalAmount = $invoice->items->sum('total');
            $invoice->update(['total_amount' => $totalAmount]);
        });
    }
}