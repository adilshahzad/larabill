<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as Log;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    // Show form to create a receipt for a specific invoice
    public function create(Invoice $invoice)
    {
        return view('receipts.create', compact('invoice'));
    }

    // Store a new receipt
    public function store(Request $request, Invoice $invoice)
    {
        // Check if the invoice is already paid
        if ($invoice->status === 'paid') {
            return redirect()->route('invoices.show', $invoice->id)
                ->with('error', 'Cannot create a receipt for a paid invoice.');
        }
        
        $request->validate([
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        $invoice->receipts()->create([
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'amount_paid' => $request->amount_paid,
        ]);

        // Calculate total paid (including advance payments)
        $totalPaid = $request->amount_paid + $invoice->advance_payment;

        // Update the invoice status & advance payments
        if ($totalPaid > $invoice->total_amount) {
            $advancePayment = $totalPaid - $invoice->total_amount;
            $invoice->update([
                'status' => 'paid',
                'advance_payment' => $advancePayment,
            ]);
        } elseif ($totalPaid == $invoice->total_amount) {
            $invoice->update(['status' => 'paid']);
        } else {
            $invoice->update(['status' => 'partially_paid']);
        }

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Receipt created successfully.');
    }

    // Show a specific receipt
    public function show(Receipt $receipt)
    {
        return view('receipts.show', compact('receipt'));
    }

    // Download receipt as PDF
    public function downloadPdf(Receipt $receipt)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('receipts.pdf', compact('receipt'));
        return $pdf->download('receipt-' . $receipt->id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
