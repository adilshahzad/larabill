@extends('layouts.app')

@section('content')
<div class="container">

    
    <div class="row">
        <div class="col-md-6"><h1>Invoice #{{ $invoice->id }}</h1></div>
        <div class="col-md-6 text-end"><img src="{{ asset('images/logo.png') }}" alt="Eaglet Informatics" style="max-width: 150px;"></div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h3>Invoice Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Customer:</strong> {{ $invoice->customer->name }}</p>
                    <p><strong>Email:</strong> {{ $invoice->customer->email }}</p>
                    <p><strong>Phone:</strong> {{ $invoice->customer->phone }}</p>
                    <p><strong>Address:</strong> {{ $invoice->customer->address }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>
                    <p><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
                    <p><strong>Total Amount:</strong> {{ number_format($invoice->total_amount, 2) }}</p>
                </div>
                <div class="col-md-3">    
                    <p><strong>Total Paid:</strong> {{ number_format($invoice->total_paid, 2) }}</p>
                    <p><strong>Advance Payment:</strong> {{ number_format($invoice->advance_payment, 2) }}</p>

                    <p><strong>Status:</strong> 
                    <span class="badge 
                        @if($invoice->status == 'paid') bg-success
                        @elseif($invoice->status == 'partially_paid') bg-warning
                        @else bg-danger
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                    </span>
                    </p>

                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Invoice Items</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total Amount</th>
                        <th>{{ number_format($invoice->total_amount, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="mt-4">
        @if($invoice->status !== 'paid')
            <a href="{{ route('receipts.create', $invoice->id) }}" class="btn btn-success">Create Receipt</a>
        @endif
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back to Invoices</a>
        <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-primary">Download Invoice PDF</a>
    </div>

    @if ($invoice->receipts->count() > 0)
        <h3>Receipts</h3>
        <ul>
            @foreach ($invoice->receipts as $receipt)
                <li>
                    <a href="{{ route('receipts.show', $receipt->id) }}">Receipt #{{ $receipt->id }}</a>
                </li>
            @endforeach
        </ul>
    @endif





</div>
@endsection