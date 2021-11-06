<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instock extends Model
{
    use HasFactory;

    protected $table = 'instocks';

    protected $fillable = [
        'stock_id',
        'stock'
    ];

    public function stok()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}
