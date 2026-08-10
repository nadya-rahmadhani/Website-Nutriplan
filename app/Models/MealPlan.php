<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model
{
    protected $fillable = ['user_id', 'name', 'is_active'];

    public function schedules()
    {
        return $this->hasMany(MealSchedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}