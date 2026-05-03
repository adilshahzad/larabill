<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $receipt->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .receipt { width: 100%; max-width: 800px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 8px; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>Receipt #{{ $receipt->id }}</h1>
        </div>
        <div class="details">
            <p><strong>Invoice ID:</strong> {{ $receipt->invoice_id }}</p>
            <p><strong>Payment Date:</strong> {{ $receipt->payment_date }}</p>
            <p><strong>Payment Method:</strong> {{ $receipt->payment_method }}</p>
            <p><strong>Amount Paid:</strong> {{ number_format($receipt->amount_paid, 2) }}</p>
        </div>
    </div>
</body>
</html>