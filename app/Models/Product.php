<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function getPriceAttribute($value)
    {
        return number_format($value, 2);
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = round($value, 2);
    }
}
