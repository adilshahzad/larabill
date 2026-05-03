@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Customer Details: {{ $customer->name }}</h1>
    <div class="card mb-4">
        <div class="card-header">
            <h3>Customer Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $customer->name }}</p>
                    <p><strong>Email:</strong> {{ $customer->email }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Phone:</strong> {{ $customer->phone }}</p>
                    <p><strong>Address:</strong> {{ $customer->address }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Invoices</h3>
        </div>
        <div class="card-body">
            @if ($customer->invoices->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Total Amount</th>
                            <th>Amount Received</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer->invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->due_date }}</td>
                                <td>{{ number_format($invoice->total_amount, 2) }}</td>
                                <td>{{ number_format($invoice->total_paid, 2) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($invoice->status == 'paid') bg-success
                                        @elseif($invoice->status == 'partially_paid') bg-warning
                                        @else bg-danger
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No invoices found for this customer.</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Receipts</h3>
        </div>
        <div class="card-body">
            @if ($customer->invoices->flatMap->receipts->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Invoice ID</th>
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <th>Amount Paid</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer->invoices->flatMap->receipts as $receipt)
                            <tr>
                                <td>{{ $receipt->id }}</td>
                                <td>{{ $receipt->invoice_id }}</td>
                                <td>{{ $receipt->payment_date }}</td>
                                <td>{{ $receipt->payment_method }}</td>
                                <td>{{ number_format($receipt->amount_paid, 2) }}</td>
                                <td>
                                    <a href="{{ route('receipts.show', $receipt->id) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No receipts found for this customer.</p>
            @endif
        </div>
    </div>
</div>
@endsection