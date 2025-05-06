<?php

namespace App\Http\Controllers;

use App\Models\TourCity;
use Illuminate\Http\Request;
use Nnjeim\World\Models\Country;

class TourCitiesController extends Controller
{
    public function index()
    {
        $cities = TourCity::all();
        $countries = Country::all();

        return view('tools.cities', compact('cities', 'countries'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'country_id' => 'required|integer|exists:countries,id',
        ]);

        TourCity::create($request->all());

        return redirect()->back()->with('success', 'City added successfully');
    }


    public function update(Request $request,  $city_id)
    {
        $tourCity = TourCity::findOrFail($city_id);
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|integer|exists:countries,id',
        ]);

        $tourCity->update($request->all());


        return redirect()->back()->with('success', 'City updated successfully');
    }

    public function destroy($city_id)
    {
        $tourCity = TourCity::findOrFail($city_id);
        $tourCity->delete();

        return redirect()->back()->with('success', 'City deleted successfully');
    }

}
