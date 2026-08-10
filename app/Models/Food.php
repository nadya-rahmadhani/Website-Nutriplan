<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods'; // tambahkan ini

    protected $fillable = ['food_category_id', 'name', 'image', 'description', 'calories'];

    public function category()
    {
        return $this->belongsTo(FoodCategory::class, 'food_category_id');
    }

    public function favorites()
    {
        return $this->hasMany(FavoriteFood::class);
    }
}