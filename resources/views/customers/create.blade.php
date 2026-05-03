@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($customer) ? 'Edit Customer' : 'Create Customer' }}</h1>
    <form action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}" method="POST">
        @csrf
        @if (isset($customer))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ isset($customer) ? $customer->name : old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ isset($customer) ? $customer->email : old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ isset($customer) ? $customer->phone : old('phone') }}">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control">{{ isset($customer) ? $customer->address : old('address') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($customer) ? 'Update' : 'Create' }}</button>
    </form>
</div>
@endsection