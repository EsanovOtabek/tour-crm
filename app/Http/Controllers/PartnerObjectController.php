<?php

namespace App\Http\Controllers;

use App\Models\PartnerObject;
use Illuminate\Http\Request;

class PartnerObjectController extends Controller
{
    protected function middleware(): array
    {
        return [
            'permission:partner-objects.store' => ['only' => ['store']],
            'permission:partner-objects.show' => ['only' => ['show']],
            'permission:partner-objects.update' => ['only' => ['update']],
            'permission:partner-objects.destroy' => ['only' => ['destroy']],
        ];
    }
    // Yangi obyekt yaratish
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'unique_code'=>'nullable|string',
            'rating' => 'nullable|numeric',
            'partner_id' => 'required|exists:partners,id',
            'tour_city_id' => 'required|exists:tour_cities,id',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $object = PartnerObject::create($validated);
        return redirect()->back()->with('success', 'Object created');
    }

    // Bitta obyektni ko‘rish
    public function show($id)
    {
        $object = PartnerObject::with('partner')->findOrFail($id);
        return response()->json($object);
    }

    // Yangilash
    public function update(Request $request, PartnerObject $partnerObject)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'unique_code'=>'nullable|string',
            'rating' => 'nullable|numeric',
            'partner_id' => 'sometimes|required|exists:partners,id',
            'tour_city_id' => 'required|exists:tour_cities,id',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $partnerObject->update($validated);

        return redirect()->back()->with('success', 'Object updated');
    }

    // O‘chirish
    public function destroy(PartnerObject $partnerObject)
    {
        $partnerObject->delete();

        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
