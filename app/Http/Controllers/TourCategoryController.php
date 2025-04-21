<?php

namespace App\Http\Controllers;

use App\Models\TourCategory;
use Illuminate\Http\Request;

class TourCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tourCategories = TourCategory::all();

        return view('tours.categories', compact('tourCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        TourCategory::create($request->all());
        return redirect()->back()->with('success', "Tour Category added successfully!");
    }


    public function update(Request $request, TourCategory $tourCategory)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $tourCategory->update($request->all());
        return redirect()->back()->with('success', "Tour Category updated successfully!");
    }

    public function destroy(TourCategory $tourCategory)
    {
        $tourCategory->delete();
        return redirect()->back()->with('success', "Tour Category deleted successfully!");
    }
}
