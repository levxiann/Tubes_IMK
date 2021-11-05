<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $table = 'receipts';

    protected $fillable = [
        'payment_id',
        'stock_id',
        'quantity',
        'price'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
