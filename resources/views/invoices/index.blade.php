@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Invoices</h1>
    
    <!-- Statistics Section -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Invoices</h5>
                    <p class="card-text h4">{{ $invoices->total() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Paid</h5>
                    <p class="card-text h4">PKR {{ number_format($totalPaid, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Unpaid</h5>
                    <p class="card-text h4">PKR {{ number_format($totalUnpaid, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">Create New Invoice</a>
        </div>
        <div class="col-md-9">
            <form action="{{ route('invoices.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by customer" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partially_paid" {{ request('status') == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="due_date" class="form-control" value="{{ request('due_date') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="min_amount" class="form-control" placeholder="Min Amount" value="{{ request('min_amount') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="max_amount" class="form-control" placeholder="Max Amount" value="{{ request('max_amount') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-secondary w-100">Search</button>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Invoice Date</th>
                <th>Due Date</th>
                <th>Total Amount</th>
                <th>Amount Received</th>
                <th>Balance</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td><a href="{{ route('customers.show', $invoice->customer->id)}}">{{ $invoice->customer->name }}</a></td>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>{{ $invoice->due_date }}</td>
                    <td>{{ number_format($invoice->total_amount, 2) }}</td>
                    <td>{{ number_format($invoice->total_paid, 2) }}</td>
                    <td>{{ number_format(($invoice->total_amount - $invoice->total_paid),2) }}</td>
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
    <!-- Pagination Links -->
    {{ $invoices->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
</div>
@endsection