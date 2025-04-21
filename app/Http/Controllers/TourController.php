<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourCategory;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategoryId = $request->input('category_id');

        $tours = Tour::with('category')
            ->when($selectedCategoryId, function ($query) use ($selectedCategoryId) {
                return $query->where('tour_category_id', $selectedCategoryId);
            })
            ->paginate(10);

        $categories = TourCategory::all();

        return view('tours.index', compact('tours', 'categories', 'selectedCategoryId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:tours,code',
            'unique-code' => 'required|string|max:50|unique:tours,unique-code',
            'status' => 'required|string|max:50',
            'day_quantity' => 'required|integer|min:1',
            'tour_category_id' => 'required|exists:tour_categories,id',
        ]);

        Tour::create($validated);

        return redirect()->back()->with('success', 'Tour created successfully.');
    }

    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:tours,code,'.$tour->id,
            'unique-code' => 'required|string|max:50|unique:tours,unique-code,'.$tour->id,
            'status' => 'required|string|max:50',
            'day_quantity' => 'required|integer|min:1',
            'tour_category_id' => 'required|exists:tour_categories,id',
        ]);

        $tour->update($validated);

        return redirect()->back()->with('success', 'Tour updated successfully.');
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();
        return redirect()->back()->with('success', 'Tour deleted successfully.');
    }
}
