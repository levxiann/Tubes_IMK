<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'percentage'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
