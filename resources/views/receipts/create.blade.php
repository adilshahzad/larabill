@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Receipt for Invoice #{{ $invoice->id }}</h1>
    <form action="{{ route('receipts.store', $invoice->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="payment_date">Payment Date</label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="Cash">Cash</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>
        </div>
        <div class="form-group">
            <label for="amount_paid">Amount Paid</label>
            <input type="number" name="amount_paid" id="amount_paid" class="form-control" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Receipt</button>
    </form>
</div>
@endsection