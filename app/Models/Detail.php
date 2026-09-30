<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'food_id',
        'calories',
        'ingredients',
        'allergens'
    ];
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
