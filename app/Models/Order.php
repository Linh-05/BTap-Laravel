<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'phone_number',
        'status'
    ];
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'food_order')
                    ->withPivot('order_quantity')
                    ->withTimestamps();
    }
}
