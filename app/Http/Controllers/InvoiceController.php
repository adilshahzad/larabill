<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\InvoiceItem;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $dueDate = $request->query('due_date');
        $minAmount = $request->query('min_amount');
        $maxAmount = $request->query('max_amount');
    
        $invoices = Invoice::with('customer')
            ->when($search, function ($query, $search) {
                return $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($dueDate, function ($query, $dueDate) {
                return $query->where('due_date', $dueDate);
            })
            ->when($minAmount, function ($query, $minAmount) {
                return $query->where('total_amount', '>=', $minAmount);
            })
            ->when($maxAmount, function ($query, $maxAmount) {
                return $query->where('total_amount', '<=', $maxAmount);
            })
            ->paginate(25);

        // Calculate statistics    
        $totalPaid = Receipt::sum('amount_paid');
        $totalInvoiceAmount = Invoice::where('status', 'unpaid')->sum('total_amount');

        $totalUnpaid = $totalInvoiceAmount; // $totalInvoiceAmount - $totalPaid;

        return view('invoices.index', compact('invoices', 'totalPaid', 'totalUnpaid'));
    }    

    public function create()
    {
        $customers = Customer::all();
        return view('invoices.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'items' => 'required|array',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric',// Allow negative values
        ]);

        // Fetch the customer
        $customer = Customer::findOrFail($request->customer_id);

        // Calculate the total amount for the new invoice
        $totalAmount = 0;
        foreach ($request->items as $item) {
            $totalAmount += $item['quantity'] * $item['unit_price'];
        }
        
        // Check if the customer has an advance payment
        $advancePayment = $customer->invoices->sum('advance_payment');

        // Apply the advance payment to the new invoice
        if ($advancePayment > 0) {
            $remainingAmount = max(0, $totalAmount - $advancePayment); // Ensure the amount doesn't go negative
            $advancePaymentUsed = min($advancePayment, $totalAmount); // Use only the required advance payment
        } else {
            $remainingAmount = $totalAmount;
            $advancePaymentUsed = 0;
        }

        // Create the new invoice
        $invoice = Invoice::create([
            'customer_id' => $request->customer_id,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'total_amount' => $remainingAmount,
            'advance_payment' => $advancePaymentUsed, // Record the advance payment used
            'status' => $remainingAmount > 0 ? 'unpaid' : 'paid', // Update status based on remaining amount
        ]);

        // $invoice = Invoice::create([
        //     'customer_id' => $request->customer_id,
        //     'invoice_date' => $request->invoice_date,
        //     'due_date' => $request->due_date,
        //     'total_amount' => 0, // Will be calculated below
        // ]);

        // Create invoice items
        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        // $totalAmount = 0;
        // foreach ($request->items as $item) {
        //     $total = $item['quantity'] * $item['unit_price'];
        //     $totalAmount += $total;

        //     InvoiceItem::create([
        //         'invoice_id' => $invoice->id,
        //         'description' => $item['description'],
        //         'quantity' => $item['quantity'],
        //         'unit_price' => $item['unit_price'],
        //         'total' => $total,
        //     ]);
        // }
        
        // Update the customer's advance payment balance
        $customer->invoices()->where('advance_payment', '>', 0)->update([
            'advance_payment' => $advancePayment - $advancePaymentUsed,
        ]);

        // $invoice->update(['total_amount' => $totalAmount]);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $customers = Customer::all();
        return view('invoices.edit', compact('invoice', 'customers'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'items' => 'required|array',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $invoice->update([
            'customer_id' => $request->customer_id,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
        ]);

        $invoice->items()->delete(); // Delete old items
        $totalAmount = 0;
        foreach ($request->items as $item) {
            $total = $item['quantity'] * $item['unit_price'];
            $totalAmount += $total;

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $total,
            ]);
        }

        $invoice->update(['total_amount' => $totalAmount]);

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function downloadPdf($id)
    {
        $invoice = Invoice::findOrFail($id);
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->stream('invoice-' . $invoice->id . '.pdf');
        // return $pdf->download('invoice-' . $invoice->id . '.pdf');
    }
}