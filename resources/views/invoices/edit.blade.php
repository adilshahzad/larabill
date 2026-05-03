@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Invoice #{{ $invoice->id }}</h1>
    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="customer_id">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-control" required>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="invoice_date">Invoice Date</label>
                    <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ $invoice->invoice_date }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $invoice->due_date }}" required>
                </div>
            </div>
        </div>

        <h3>Invoice Items</h3>
        <div id="items">
            @foreach ($invoice->items as $index => $item)
                <div class="item">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" name="items[{{ $index }}][description]" class="form-control" value="{{ $item->description }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="items[{{ $index }}][quantity]" class="form-control" value="{{ $item->quantity }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="unit_price">Unit Price</label>
                                <input type="number" name="items[{{ $index }}][unit_price]" class="form-control" value="{{ $item->unit_price }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="total">Total</label>
                                <input type="text" class="form-control" value="{{ number_format($item->total, 2) }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-remove-item" style="margin-top: 30px;">Remove</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-item" class="btn btn-secondary">Add Item</button>
        <button type="submit" class="btn btn-primary">Update Invoice</button>
    </form>
</div>

<script>
    // Add new item row
    document.getElementById('add-item').addEventListener('click', function () {
        const itemsDiv = document.getElementById('items');
        const index = itemsDiv.querySelectorAll('.item').length;
        const newItem = `
            <div class="item">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="items[${index}][description]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="items[${index}][quantity]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="unit_price">Unit Price</label>
                            <input type="number" name="items[${index}][unit_price]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-remove-item" style="margin-top: 30px;">Remove</button>
                    </div>
                </div>
            </div>
        `;
        itemsDiv.insertAdjacentHTML('beforeend', newItem);
    });

    // Remove item row
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('btn-remove-item')) {
            e.target.closest('.item').remove();
        }
    });
</script>
@endsection