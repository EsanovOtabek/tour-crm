<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Partner;
use App\Models\PartnerObject;
use App\Models\PartnerType;
use App\Models\ObjectItem;
use Illuminate\Http\Request;

class BookingDetailController extends Controller
{
    public function index(Booking $booking)
    {
        $bookingDetails = $booking->details()
            ->with([
                'booking',
                'objectItem',
                'user'
            ])
            ->orderBy('start_date')
            ->get();

        $partnerTypes = PartnerType::with('partners')->get();
        $partners = Partner::with('partnerObjects')->get();
        $partnerObjects = PartnerObject::with('items')->get();
        $objectItems = ObjectItem::all();

        return view('bookings.details', compact(
            'bookingDetails',
            'booking',
            'partnerTypes',
            'partners',
            'partnerObjects',
            'objectItems',
        ));
    }

    public function store(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'type_id' => 'required|exists:partner_types,id',
            'partner_id' => 'required|exists:partners,id',
            'partner_object_id' => 'required|exists:partner_objects,id',
            'object_item_id' => 'required|exists:object_items,id',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'comment' => 'nullable|string',
        ]);

        // Verify the relationship chain
        $objectItem = ObjectItem::with('partnerObject.partner')->findOrFail($data['object_item_id']);
        $partnerObject = PartnerObject::with('partner')->findOrFail($data['partner_object_id']);
        $partner = Partner::findOrFail($data['partner_id']);

        // Validate relationships
        if ($objectItem->partner_object_id != $partnerObject->id) {
            return redirect()->back()->with('error', 'Selected object does not belong to the selected partner object.');
        }

        if ($partnerObject->partner_id != $partner->id) {
            return redirect()->back()->with('error', 'Selected partner object does not belong to the selected partner.');
        }

        if ($partner->type_id != $data['type_id']) {
            return redirect()->back()->with('error', 'Selected partner does not belong to the selected type.');
        }

        // Price calculation
        $data['price'] = $objectItem->sale_price * $data['quantity'];
        $data['cost_price'] = $objectItem->price * $data['quantity'];
        $data['user_id'] = auth()->id();



        $booking->details()->create($data);

        return redirect()->back()->with('success', 'Booking detail added successfully.');
    }

    public function update(Request $request, Booking $booking, BookingDetail $detail)
    {
        $data = $request->validate([
            'type_id' => 'required|exists:partner_types,id',
            'partner_id' => 'required|exists:partners,id',
            'partner_object_id' => 'required|exists:partner_objects,id',
            'object_item_id' => 'required|exists:object_items,id',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'comment' => 'nullable|string',
        ]);

        // Verify the relationship chain
        $objectItem = ObjectItem::with('partnerObject.partner')->findOrFail($data['object_item_id']);
        $partnerObject = PartnerObject::with('partner')->findOrFail($data['partner_object_id']);
        $partner = Partner::findOrFail($data['partner_id']);

        // Validate relationships
        if ($objectItem->partner_object_id != $partnerObject->id) {
            return redirect()->back()->with('error', 'Selected object does not belong to the selected partner object.');
        }

        if ($partnerObject->partner_id != $partner->id) {
            return redirect()->back()->with('error', 'Selected partner object does not belong to the selected partner.');
        }

        if ($partner->type_id != $data['type_id']) {
            return redirect()->back()->with('error', 'Selected partner does not belong to the selected type.');
        }

        // Price calculation
        $data['price'] = $objectItem->sale_price * $data['quantity'];
        $data['cost_price'] = $objectItem->price * $data['quantity'];

        $detail->update($data);

        return redirect()->back()->with('success', 'Booking detail updated successfully.');
    }
    public function destroy(Booking $booking, BookingDetail $detail)
    {
        $detail->delete();
        return redirect()->back()->with('success', 'Booking detail deleted successfully.');
    }

    // API: Get objects by partner
    public function getObjectsByPartner(Partner $partner)
    {
        $objects = $partner->objects()->get(); // Make sure Partner model has objects() relationship
        return response()->json($objects);
    }
}
