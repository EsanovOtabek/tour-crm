<?php

namespace App\Http\Controllers;

use App\Models\PriceList;
use App\Models\Tour;
use Illuminate\Http\Request;

class PriceListController extends Controller
{
    public function index()
    {
        $priceLists = PriceList::paginate(10);
        $tours = Tour::all();

        return view('tours.price-list', compact('priceLists', 'tours'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        PriceList::create($validated);

        return redirect()->back()->with('success', 'Price list item created successfully.');
    }


    public function update(Request $request, PriceList $priceList)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $priceList->update($validated);

        return redirect()->back()->with('success', 'Price list item updated successfully.');
    }

    public function destroy(PriceList $priceList)
    {
        $priceList->delete();

        return redirect()->back()->with('success', 'Price list item deleted successfully.');
    }
}
