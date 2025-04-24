<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Partner;
use App\Models\ObjectItem;
use Illuminate\Http\Request;

class BookingDetailController extends Controller
{
    public function index(Booking $booking)
    {
        $bookingDetails = $booking->details()->with(['partner', 'objectItem'])->get();
        $partners = Partner::all();

        return view('bookings.details', compact('bookingDetails', 'booking', 'partners'));
    }

    public function store(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'object_item_id' => 'required|exists:object_items,id',
            'quantity' => 'required|integer|min:1',
            'sana' => 'nullable|date',
            'comment' => 'nullable|string',
        ]);

        // Get the object item to calculate prices
        $objectItem = ObjectItem::findOrFail($data['object_item_id']);

        $data['price'] = $objectItem->sale_price * $data['quantity'];
        $data['cost_price'] = $objectItem->price * $data['quantity'];
        $data['user_id'] = auth()->id();

        $booking->details()->create($data);

        return redirect()->back()->with('success', 'Booking detail added successfully.');
    }

    public function update(Request $request, Booking $booking, BookingDetail $detail)
    {
        $data = $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'object_item_id' => 'required|exists:object_items,id',
            'quantity' => 'required|integer|min:1',
            'sana' => 'nullable|date',
            'comment' => 'nullable|string',
        ]);

        // Get the object item to calculate prices
        $objectItem = ObjectItem::findOrFail($data['object_item_id']);

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
}
