@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($invoice) ? 'Edit Invoice' : 'Create Invoice' }}</h1>
    <form action="{{ isset($invoice) ? route('invoices.update', $invoice->id) : route('invoices.store') }}" method="POST">
        @csrf
        @if (isset($invoice))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="customer_id">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control" required>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ isset($invoice) && $invoice->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="invoice_date">Invoice Date</label>
            <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ isset($invoice) ? $invoice->invoice_date : old('invoice_date') }}" required>
        </div>
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ isset($invoice) ? $invoice->due_date : old('due_date') }}" required>
        </div>
        <div id="items">
            <h3>Items</h3>
            @if (isset($invoice))
                @foreach ($invoice->items as $index => $item)
                    <div class="item">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="items[{{ $index }}][description]" class="form-control" value="{{ $item->description }}" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="items[{{ $index }}][quantity]" class="form-control" value="{{ $item->quantity }}" required>
                        </div>
                        <div class="form-group">
                            <label for="unit_price">Unit Price</label>
                            <input type="number" name="items[{{ $index }}][unit_price]" class="form-control" value="{{ $item->unit_price }}" required>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="item">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="items[0][description]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="items[0][quantity]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="unit_price">Unit Price</label>
                        <input type="number" name="items[0][unit_price]" class="form-control" required>
                    </div>
                </div>
            @endif
        </div>
        <button type="button" id="add-item" class="btn btn-secondary">Add Item</button>
        <button type="submit" class="btn btn-primary">{{ isset($invoice) ? 'Update' : 'Create' }}</button>
    </form>
</div>

<script>
    document.getElementById('add-item').addEventListener('click', function () {
        const itemsDiv = document.getElementById('items');
        const index = itemsDiv.querySelectorAll('.item').length;
        const newItem = `
            <div class="item">
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="items[${index}][description]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="items[${index}][quantity]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="unit_price">Unit Price</label>
                    <input type="number" name="items[${index}][unit_price]" class="form-control" required>
                </div>
            </div>
        `;
        itemsDiv.insertAdjacentHTML('beforeend', newItem);
    });
</script>
@endsection