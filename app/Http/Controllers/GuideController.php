<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\GuideCategory;
use App\Models\TourCity;
use Illuminate\Http\Request;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Language;

class GuideController extends Controller
{
    public function index()
    {

        $guides = Guide::paginate(10);
        $categories = GuideCategory::all();
        $languages = Language::all();
        $tour_cities = TourCity::all();

        return view('guides.index', compact('guides', 'categories', 'languages', 'tour_cities'));
    }

    public function store(Request $request)
    {
        $guide = Guide::create($request->only(['name', 'status', 'guide_category_id', 'tour_city_id', 'price']));
        $guide->languages()->sync($request->languages);
        return redirect()->back()->with('success', 'Guide added!');
    }

    public function update(Request $request, Guide $guide)
    {
        $guide->update($request->only(['name', 'status', 'guide_category_id', 'tour_city_id', 'price']));
        $guide->languages()->sync($request->languages);
        return redirect()->back()->with('success', 'Guide updated!');
    }

    public function destroy(Guide $guide)
    {
        $guide->delete();
        return redirect()->back()->with('success', 'Guide deleted!');
    }

}
