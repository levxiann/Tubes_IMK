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
        'wholesale_quantity',
        'stock',
        'image',
        'status'
    ];

    protected $table = 'stocks';

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public function receipt()
    {
        return $this->hasMany(Receipt::class);
    }

    public function instocks()
    {
        return $this->hasMany(Instock::class);
    }

    public function brokens()
    {
        return $this->hasMany(Broken::class);
    }
}
