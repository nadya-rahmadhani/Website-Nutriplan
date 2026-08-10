<?php

namespace App\Http\Controllers;

use App\Models\FavoriteFood;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FavoriteFoodController extends Controller
{
    public function index(): View
    {
        $favorites = FavoriteFood::with('food.category')
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->paginate(12);

        return view('foods.favorites', compact('favorites'));
    }

    public function toggle(Request $request, $foodId): RedirectResponse
    {
        $existing = FavoriteFood::where('user_id', auth()->id())
                        ->where('food_id', $foodId)
                        ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Dihapus dari favorit.';
        } else {
            FavoriteFood::create([
                'user_id' => auth()->id(),
                'food_id' => $foodId,
            ]);
            $message = 'Ditambahkan ke favorit!';
        }

        return redirect()->back()->with('success', $message);
    }
}