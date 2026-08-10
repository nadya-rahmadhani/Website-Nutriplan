<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealSchedule extends Model
{
    protected $fillable = ['meal_plan_id', 'day', 'meal_type', 'menu', 'is_done'];

    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class);
    }
}