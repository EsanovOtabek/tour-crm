<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PriceList;
use App\Models\Tour;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', null);
        $query = Booking::query();

        if ($filter === 'archive') {
            $query->where('end_date', '<', Carbon::now());
        } elseif (in_array($filter, ['pending', 'confirmed', 'cancelled', 'completed'])) {
            $query->where('end_date', '>=', Carbon::now())
                ->where('status', $filter);
        } else {
            $query->where('end_date', '>=', Carbon::now());
        }

        $bookings = $query->paginate(12);
        $tours = Tour::all();
        $priceList = PriceList::all();

        return view('bookings.index', compact('bookings', 'tours', 'priceList'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([

            'tour_id' => 'required|exists:tours,id',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
        ]);

        // Calculate total_amount based on other fields if needed
        $validated['total_amount'] = $request->input('total_amount', $validated['price']);
        $validated['user_id'] = auth()->user()->id;

        Booking::create($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
        ]);

        // Calculate total_amount based on other fields if needed
        $validated['total_amount'] = $request->input('total_amount', $validated['price']);

        $booking->update($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}
