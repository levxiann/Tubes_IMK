<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'wholesale_price',
        'stock',
        'image'
    ];

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public function receipt()
    {
        return $this->hasMany(Receipt::class);
    }
}
