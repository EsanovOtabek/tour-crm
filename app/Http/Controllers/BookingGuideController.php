<?php
namespace App\Http\Controllers;

use App\Models\BookingGuide;
use App\Models\Booking;
use App\Models\Guide;
use App\Models\TourCity;
use Illuminate\Http\Request;

class BookingGuideController extends Controller
{
    public function index(Booking $booking)
    {
        $bookingGuides = $booking->guides;
//        dd();
        $guides = Guide::all();
        $cities = TourCity::all();

        return view('bookings.guides', compact('bookingGuides', 'booking', 'guides', 'cities'));
    }

    public function store(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'guide_id' => 'required|exists:guides,id',
            'tour_city_id' => 'nullable|exists:tour_cities,id',
            'summa' => 'required|numeric',
            'comment' => 'nullable|string',
            'sana' => 'nullable|date',
        ]);

        $data['user_id'] = auth()->user()->id;

        $booking->guides()->create($data);

        return redirect()->back()->with('success', 'Booking guide added successfully.');
    }

    public function update(Request $request, Booking $booking, BookingGuide $bookingGuide)
    {
        $validated = $request->validate([
            'guide_id' => 'required|exists:guides,id',
            'tour_city_id' => 'nullable|exists:tour_cities,id',
            'summa' => 'required|numeric',
            'comment' => 'nullable|string',
            'sana' => 'nullable|date',
        ]);

        $bookingGuide->update($validated);
        return redirect()->back()->with('success', 'Booking guide updated successfully.');
    }

    public function destroy(Booking $booking, BookingGuide $bookingGuide)
    {
        $bookingGuide->delete();
        return redirect()->back()->with('success', 'Booking guide deleted.');
    }
}
