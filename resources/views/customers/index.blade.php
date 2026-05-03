@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Customers</h1>
    <div class="row mb-4">
        <div class="col-md-6">
            <a href="{{ route('customers.create') }}" class="btn btn-primary">Add New Customer</a>
        </div>
        <div class="col-md-6">
            <form action="{{ route('customers.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary ms-2">Search</button>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>
                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
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
    {{ $customers->appends(['search' => request('search')])->links('vendor.pagination.bootstrap-5') }}
</div>
@endsection