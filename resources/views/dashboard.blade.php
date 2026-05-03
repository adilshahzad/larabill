@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard</h1>

    <!-- Key Metrics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <h2 class="card-text">{{ number_format($totalCustomers) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Invoices</h5>
                    <h2 class="card-text">{{ number_format($totalInvoices) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <h2 class="card-text">PKR {{ number_format($totalRevenue, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Total Due</h5>
                    <h2 class="card-text">PKR {{ number_format($totalDue, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Monthly Revenue Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Invoice Status Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                    <div class="mt-3">
                        <span class="badge bg-success">Paid:</span> {{ $paidInvoices }} 
                        <span class="badge bg-warning">Partially Paid:</span> {{ $partiallyPaidInvoices }}
                        <span class="badge bg-danger">Unpaid:</span> {{ $unpaidInvoices }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <strong>Recent Invoices</strong>
                    <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-primary float-end">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentInvoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id }}</td>
                                        <td>{{ $invoice->customer->name }}</td>
                                        <td> {{ number_format($invoice->total_amount, 2) }}</td>
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <strong>Recent Customers</strong>
                    <a href="{{ route('customers.index') }}" class="btn btn-sm btn-primary float-end">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentCustomers as $customer)
                                    <tr>
                                        <td>{{ $customer->id }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>
                                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Revenue (PKR)',
                data: @json($revenues),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Status Chart
    const ctx2 = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Partially Paid', 'Unpaid'],
            datasets: [{
                data: [{{ $paidInvoices }}, {{ $partiallyPaidInvoices }}, {{ $unpaidInvoices }}],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
</script>
@endsection