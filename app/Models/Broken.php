<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broken extends Model
{
    use HasFactory;

    protected $table = 'brokens';

    protected $fillable = [
        'stock_id',
        'desc',
        'broken_stock'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
