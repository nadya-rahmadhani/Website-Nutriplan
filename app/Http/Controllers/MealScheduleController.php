<?php

namespace App\Http\Controllers;

use App\Models\MealSchedule;
use App\Models\MealPlan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MealScheduleController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'meal_plan_id' => 'required|exists:meal_plans,id',
            'day'          => 'required|string',
            'meal_type'    => 'required|in:sarapan,siang,malam',
            'menu'         => 'required|min:3',
        ]);

        MealSchedule::create($request->all());

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan!');
    }

    public function update(Request $request, MealSchedule $mealSchedule): RedirectResponse
    {
        $request->validate([
            'day'       => 'required|string',
            'meal_type' => 'required|in:sarapan,siang,malam',
            'menu'      => 'required|min:3',
        ]);

        $mealSchedule->update($request->all());

        return redirect()->back()->with('success', 'Menu berhasil diubah!');
    }

    public function destroy(MealSchedule $mealSchedule): RedirectResponse
    {
        $mealSchedule->delete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    public function toggle(MealSchedule $mealSchedule): RedirectResponse
    {
        $mealSchedule->update(['is_done' => !$mealSchedule->is_done]);
        return redirect()->back()->with('success', 'Status berhasil diubah!');
    }
}