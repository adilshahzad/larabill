@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Receipt #{{ $receipt->id }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Invoice ID:</strong> {{ $receipt->invoice_id }}</p>
            <p><strong>Payment Date:</strong> {{ $receipt->payment_date }}</p>
            <p><strong>Payment Method:</strong> {{ $receipt->payment_method }}</p>
            <p><strong>Amount Paid:</strong> {{ number_format($receipt->amount_paid, 2) }}</p>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('invoices.show', $receipt->invoice_id) }}" class="btn btn-secondary">Back to Invoice</a>
        <a href="{{ route('receipts.download', $receipt->id) }}" class="btn btn-primary">Download PDF</a>
    </div>
</div>
@endsection