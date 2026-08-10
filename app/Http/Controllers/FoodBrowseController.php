<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\FavoriteFood;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FoodBrowseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Food::with('category');

        // Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->category_id) {
            $query->where('food_category_id', $request->category_id);
        }

        // Sorting
        $sort = $request->sort ?? 'latest';
        if ($sort === 'calories_asc') {
            $query->orderBy('calories', 'asc');
        } elseif ($sort === 'calories_desc') {
            $query->orderBy('calories', 'desc');
        } elseif ($sort === 'name_asc') {
            $query->orderBy('name', 'asc');
        } else {
            $query->latest();
        }

        $foods      = $query->paginate(12)->withQueryString();
        $categories = FoodCategory::all();

        // ID makanan yang sudah difavoritkan user ini
        $favoriteIds = FavoriteFood::where('user_id', auth()->id())
                        ->pluck('food_id')
                        ->toArray();

        return view('foods.index', compact('foods', 'categories', 'favoriteIds', 'sort'));
    }
}