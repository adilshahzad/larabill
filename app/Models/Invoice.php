<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'customer_id',
        'invoice_date',
        'due_date',
        'total_amount',
        'status',
        'advance_payment',
    ];

    public function getTotalPaidAttribute()
    {
        return $this->receipts->sum('amount_paid');
    }

    public function getStatusAttribute()
    {
        $totalPaid = $this->total_paid;
        $totalAmount = $this->total_amount;

        if ($totalPaid >= $totalAmount) {
            return 'paid';
        } elseif ($totalPaid > 0) {
            return 'partially_paid';
        } else {
            return 'unpaid';
        }
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
