<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use App\Models\MealSchedule;
use App\Models\WeightLog;
use App\Models\FavoriteFood;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Meal plan terbaru user
        $activePlan = MealPlan::where('user_id', $user->id)
                        ->latest()->first();

        // Progress makan hari ini
        $hariIni = now()->locale('id')->translatedFormat('l');
        // Konversi ke bahasa Indonesia
        $hariMap = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];
        $hariIni = $hariMap[now()->format('l')];

        $todaySchedules = collect();
        if ($activePlan) {
            $todaySchedules = MealSchedule::where('meal_plan_id', $activePlan->id)
                                ->where('day', $hariIni)
                                ->orderByRaw("FIELD(meal_type, 'sarapan','siang','malam')")
                                ->get();
        }

        $totalMakan   = $todaySchedules->count();
        $selesaiMakan = $todaySchedules->where('is_done', true)->count();

        // Weight chart data
        $weightLogs = WeightLog::where('user_id', $user->id)
                        ->orderBy('logged_at')
                        ->get();

        $chartLabels = $weightLogs->pluck('logged_at')
                        ->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M Y'))
                        ->toArray();
        $chartData   = $weightLogs->pluck('weight')->toArray();

        $latestWeight = $weightLogs->last()?->weight ?? $user->current_weight;

        // Total meal plan
        $totalMealPlans = MealPlan::where('user_id', $user->id)->count();

        // Total favorit
        $totalFavorites = FavoriteFood::where('user_id', $user->id)->count();

        return view('dashboard', compact(
            'activePlan',
            'todaySchedules',
            'totalMakan',
            'selesaiMakan',
            'chartLabels',
            'chartData',
            'latestWeight',
            'totalMealPlans',
            'totalFavorites'
        ));
    }
}