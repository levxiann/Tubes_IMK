<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_id',
        'stock_id',
        'quantity',
        'status'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
