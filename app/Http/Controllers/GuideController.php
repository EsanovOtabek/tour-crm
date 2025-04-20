<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\GuideCategory;
use Illuminate\Http\Request;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Language;

class GuideController extends Controller
{
    public function index()
    {
        return view('guides.index', [
            'guides' => Guide::with(['category', 'city', 'languages'])->get(),
            'categories' => GuideCategory::all(),
            'cities' => City::all(),
            'languages' => Language::all(),
        ]);
    }

    public function store(Request $request)
    {
        $guide = Guide::create($request->only(['name', 'status', 'guide_category_id', 'city_id', 'price']));
        $guide->languages()->sync($request->languages);
        return redirect()->back()->with('success', 'Guide added!');
    }

    public function update(Request $request, Guide $guide)
    {
        $guide->update($request->only(['name', 'status', 'guide_category_id', 'city_id', 'price']));
        $guide->languages()->sync($request->languages);
        return redirect()->back()->with('success', 'Guide updated!');
    }

    public function destroy(Guide $guide)
    {
        $guide->delete();
        return redirect()->back()->with('success', 'Guide deleted!');
    }

}
