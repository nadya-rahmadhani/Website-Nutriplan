<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteFood extends Model
{
    protected $table = 'favorite_foods'; // tambahkan ini

    protected $fillable = ['user_id', 'food_id'];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}