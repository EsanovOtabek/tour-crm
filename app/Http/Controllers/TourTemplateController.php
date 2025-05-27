<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerObject;
use App\Models\PartnerType;
use App\Models\Tour;
use App\Models\TourTemplate;
use App\Models\ObjectItem;
use App\Models\TourCity;
use App\Models\TourTemplateDetail;
use App\Models\TourTemplateMashrut;
use Illuminate\Http\Request;

class TourTemplateController extends Controller
{
    public function index(Tour $tour)
    {
        if (!TourTemplate::where('tour_id', $tour->id)->exists()) {
            $tourTemplate = new TourTemplate();
            $tourTemplate->tour_id = $tour->id;
            $tourTemplate->name = $tour->{'unique-code'};
            $tourTemplate->save();
        }

        $template = TourTemplate::where('tour_id', $tour->id)->with(['mashruts', 'details'])->first();
        $objectItems = ObjectItem::all();
        $tourCities = TourCity::all();
        $partnerTypes = PartnerType::all();
        $partners = Partner::all();
        $partnerObjects = PartnerObject::all();
        return view('tours.template', compact('tour', 'template', 'objectItems', 'tourCities', 'partnerTypes', 'partners', 'partnerObjects'));
    }


    public function addDetail(Request $request, Tour $tour)
    {
        $template = TourTemplate::where('tour_id', $tour->id)->first();

        $validated = $request->validate([
            'object_item_id' => 'required|exists:object_items,id',
            'start_day' => 'required|integer|min:1|max:' . $tour->day_quantity,
            'end_day' => 'required|integer|min:1|max:' . $tour->day_quantity,
            'quantity' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'comment' => 'nullable|string',
        ]);

        $objectItem = ObjectItem::find($validated['object_item_id']);
        $validated['price'] = floatval($objectItem->sale_price*($validated['quantity']));
        $validated['cost_price'] = floatval($objectItem->price*($validated['quantity']));

        $template->details()->create($validated);

        return back()->with('success', 'Detail added successfully.');
    }

    public function updateDetail(Request $request, Tour $tour, TourTemplateDetail $detail)
    {
        $validated = $request->validate([
            'object_item_id' => 'required|exists:object_items,id',
            'start_day' => 'required|integer|min:1|max:' . $tour->day_quantity,
            'end_day' => 'required|integer|min:1|max:' . $tour->day_quantity,
            'quantity' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'comment' => 'nullable|string',
        ]);

        $detail->update($validated);

        return back()->with('success', 'Detail updated successfully.');
    }

    public function removeDetail(Tour $tour, TourTemplateDetail $detail)
    {
        $detail->delete();

        return back()->with('success', 'Detail removed successfully.');
    }

    public function addMashrut(Request $request, Tour $tour)
    {
        $template = TourTemplate::where('tour_id', $tour->id)->first();

        $validated = $request->validate([
            'tour_city_id' => 'required|exists:tour_cities,id',
            'day_number' => 'required|integer|min:1|max:' . $tour->day_quantity,
            'program' => 'nullable|string',
            'order_no' => 'nullable|integer|min:1',
        ]);
        $validated['program'] = ' ';
        $validated['order_no'] = $validated['day_number'];

        $template->mashruts()->create($validated);

        return back()->with('success', 'Mashrut added successfully.');
    }

    public function updateMashrut(Request $request, Tour $tour, TourTemplateMashrut $mashrut)
    {
        $validated = $request->validate([
            'tour_city_id' => 'required|exists:tour_cities,id',
            'day_number' => 'required|integer|min:1|max:' . $tour->day_quantity,
            'program' => 'nullable|string',
            'order_no' => 'nullable|integer|min:1',
        ]);

        $mashrut->update($validated);

        return back()->with('success', 'Mashrut updated successfully.');
    }

    public function removeMashrut(Tour $tour, TourTemplateMashrut $mashrut)
    {
        $mashrut->delete();

        return back()->with('success', 'Mashrut removed successfully.');
    }

}
