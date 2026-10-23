<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $table = 'foods';
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'quantity',
        'image',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function detail()
    {
        return $this->hasOne(Detail::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'food_order')
                    ->withPivot('order_quantity')
                    ->withTimestamps();
    }
}
