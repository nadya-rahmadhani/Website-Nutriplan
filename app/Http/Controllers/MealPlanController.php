<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use App\Models\MealSchedule;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MealPlanController extends Controller
{
    private function getTemplate(string $goal): array
    {
        $templates = [
            'diet' => [
                ['day' => 'Senin',  'meal_type' => 'sarapan', 'menu' => 'Oatmeal'],
                ['day' => 'Senin',  'meal_type' => 'siang',   'menu' => 'Ayam Panggang + Salad'],
                ['day' => 'Senin',  'meal_type' => 'malam',   'menu' => 'Sayur Rebus'],
                ['day' => 'Selasa', 'meal_type' => 'sarapan', 'menu' => 'Telur Rebus'],
                ['day' => 'Selasa', 'meal_type' => 'siang',   'menu' => 'Salad Ayam'],
                ['day' => 'Selasa', 'meal_type' => 'malam',   'menu' => 'Sup Ayam'],
                ['day' => 'Rabu',   'meal_type' => 'sarapan', 'menu' => 'Smoothie Buah'],
                ['day' => 'Rabu',   'meal_type' => 'siang',   'menu' => 'Nasi + Ikan Bakar'],
                ['day' => 'Rabu',   'meal_type' => 'malam',   'menu' => 'Tumis Kangkung'],
            ],
            'maintenance' => [
                ['day' => 'Senin',  'meal_type' => 'sarapan', 'menu' => 'Roti Gandum'],
                ['day' => 'Senin',  'meal_type' => 'siang',   'menu' => 'Nasi + Ayam Panggang'],
                ['day' => 'Senin',  'meal_type' => 'malam',   'menu' => 'Tumis Kangkung'],
                ['day' => 'Selasa', 'meal_type' => 'sarapan', 'menu' => 'Telur Rebus'],
                ['day' => 'Selasa', 'meal_type' => 'siang',   'menu' => 'Nasi + Tempe'],
                ['day' => 'Selasa', 'meal_type' => 'malam',   'menu' => 'Sup Ayam'],
                ['day' => 'Rabu',   'meal_type' => 'sarapan', 'menu' => 'Oatmeal'],
                ['day' => 'Rabu',   'meal_type' => 'siang',   'menu' => 'Nasi + Ikan Bakar'],
                ['day' => 'Rabu',   'meal_type' => 'malam',   'menu' => 'Salad Sayur'],
            ],
            'bulking' => [
                ['day' => 'Senin',  'meal_type' => 'sarapan', 'menu' => 'Oatmeal + Susu'],
                ['day' => 'Senin',  'meal_type' => 'siang',   'menu' => 'Nasi + Ayam + Telur'],
                ['day' => 'Senin',  'meal_type' => 'malam',   'menu' => 'Nasi + Kentang'],
                ['day' => 'Selasa', 'meal_type' => 'sarapan', 'menu' => 'Roti Gandum + Telur'],
                ['day' => 'Selasa', 'meal_type' => 'siang',   'menu' => 'Nasi + Ikan Bakar'],
                ['day' => 'Selasa', 'meal_type' => 'malam',   'menu' => 'Nasi + Tempe'],
                ['day' => 'Rabu',   'meal_type' => 'sarapan', 'menu' => 'Smoothie Buah + Susu'],
                ['day' => 'Rabu',   'meal_type' => 'siang',   'menu' => 'Nasi + Ayam Panggang'],
                ['day' => 'Rabu',   'meal_type' => 'malam',   'menu' => 'Nasi + Kentang + Sayur'],
            ],
        ];

        return $templates[$goal] ?? $templates['maintenance'];
    }

    public function index(): View
    {
        $mealPlans = MealPlan::where('user_id', auth()->id())
                        ->latest()->paginate(5);
        return view('meal-plans.index', compact('mealPlans'));
    }

    public function create(): View
    {
        return view('meal-plans.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|min:3']);

        $mealPlan = MealPlan::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
        ]);

        $goal     = auth()->user()->goal ?? 'maintenance';
        $template = $this->getTemplate($goal);

        foreach ($template as $item) {
            MealSchedule::create(array_merge($item, [
                'meal_plan_id' => $mealPlan->id
            ]));
        }

        return redirect()->route('meal-plans.show', $mealPlan)
                ->with('success', 'Meal plan berhasil dibuat dengan template awal!');
    }

    public function show(MealPlan $mealPlan): View
    {
        // Pastikan hanya pemiliknya yang bisa lihat
        abort_if($mealPlan->user_id !== auth()->id(), 403);

        $schedules = $mealPlan->schedules()
                        ->orderByRaw("FIELD(day, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
                        ->orderByRaw("FIELD(meal_type, 'sarapan','siang','malam')")
                        ->get()
                        ->groupBy('day');

        return view('meal-plans.show', compact('mealPlan', 'schedules'));
    }

    public function edit(MealPlan $mealPlan): View
    {
        abort_if($mealPlan->user_id !== auth()->id(), 403);
        return view('meal-plans.edit', compact('mealPlan'));
    }

    public function update(Request $request, MealPlan $mealPlan): RedirectResponse
    {
        abort_if($mealPlan->user_id !== auth()->id(), 403);
        $request->validate(['name' => 'required|min:3']);
        $mealPlan->update(['name' => $request->name]);
        return redirect()->route('meal-plans.index')
                ->with('success', 'Meal plan berhasil diubah!');
    }

    public function destroy(MealPlan $mealPlan): RedirectResponse
    {
        abort_if($mealPlan->user_id !== auth()->id(), 403);
        $mealPlan->delete();
        return redirect()->route('meal-plans.index')
                ->with('success', 'Meal plan berhasil dihapus!');
    }
}