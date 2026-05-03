<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .invoice { width: 100%; max-width: 800px; margin: 0 auto; position: relative; }

        .logo {
            position: absolute;
            top: 0;
            left: 0;
            max-width: 150px;
        }

        .customer-details {
            position: absolute;
            top: 0;
            right: 0;
            width: 250px;
            text-align: left;
        }

        .invoice-info {
            position: absolute;
            top: 30px;
            left: 0;
        }

        .invoice-number {
            position: absolute;
            top: 200px;
            left: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            margin-top: 250px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
        }
        .text-right { text-align: right; }
        .text-red { color: red; }

        .unpaid-stamp, .paid-stamp, .partially-paid-stamp {
            position: absolute;
            top: 50px;
            right: 50%;
            transform: translateX(50%) rotate(-15deg);
            padding: 10px 20px;
            font-weight: bold;
            z-index: 1;
            text-transform: uppercase;
        }
        .unpaid-stamp {
            font-size: 35px;
            color: rgba(255, 0, 0, 0.5);
            border: 5px solid rgba(255, 0, 0, 0.5);
        }
        .paid-stamp {
            font-size: 40px;
            color: rgba(0, 128, 0, 0.5);
            border: 5px solid rgba(0, 128, 0, 0.5);
        }
        .partially-paid-stamp {
            font-size: 30px;
            color: rgba(255, 165, 0, 0.94);
            border: 5px solid rgba(255, 165, 0, 0.94);
            transform: translateX(50%) rotate(-20deg);
        }

        .bank-details {
            margin-top: 30px;
            padding: 15px;
            border-top: 1px solid #ccc;
        }

        /* FOOTER CONTACT DETAILS */
        .footer-contact {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 2px solid #ccc;
            text-align: center;
            font-size: 12px;
            line-height: 1.6;
            color: #444;
        }
    </style>
</head>
<body>
    <div class="invoice">

        <!-- Invoice Status Stamp -->
        <div class="
            @if($invoice->status == 'paid') paid-stamp
            @elseif($invoice->status == 'partially_paid') partially-paid-stamp
            @else unpaid-stamp
            @endif">
            {{ str_replace('_', ' ', $invoice->status) }}
        </div>

        <!-- Logo -->
        <div class="logo">
            <img src="{{ public_path('images/logo.png') }}" alt="Eaglet Informatics" style="max-width: 100%;">
        </div>

        <!-- Customer Details -->
        <div class="customer-details">
            <p><strong>Customer:</strong> {{ $invoice->customer->name }}</p>
            <p><strong>Email:</strong> {{ $invoice->customer->email }}</p>
            <p><strong>Phone:</strong> {{ $invoice->customer->phone }}</p>
            <p><strong>Address:</strong> {{ $invoice->customer->address }}</p>
        </div>

        <!-- Invoice Dates -->
        <div class="invoice-info">
            <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
        </div>

        <!-- Invoice Number -->
        <div class="invoice-number">
            Invoice #{{ $invoice->id }}
        </div>

        <!-- Main Content -->
        <div class="content">
            <table class="table">
                <thead>
                    <tr>
                        <th width="55%">Description</th>
                        <th width="15%">Quantity</th>
                        <th width="15%">Unit Price</th>
                        <th width="15%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr @if($item->total < 0) class="text-red" @endif>
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

            <!-- Bank Details -->
            <div class="bank-details">
                <h3>Payment Details</h3>
                <p><strong>Bank Name:</strong> Meezan Bank Ltd</p>
                <p><strong>Account Name:</strong> Sayyed Adil Shahzad</p>
                <p><strong>Account Number:</strong> 03060102285002</p>
                <p><strong>IBAN:</strong> PK87MEZN0003060102285002</p>
            </div>

            <!-- FOOTER CONTACT -->
            <div class="footer-contact">
                <p><strong>Eaglet Informatics (PVT) LTD</strong></p>
                <p><strong>Phone:</strong> +92 300 0885111 | <strong>Email:</strong> info@eagletinformatics.com | <strong>Website:</strong> www.eagletinformatics.com</p>
            </div>

        </div>

    </div>
</body>
</html>
