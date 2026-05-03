<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{

    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'payment_date',
        'payment_method',
        'amount_paid',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
