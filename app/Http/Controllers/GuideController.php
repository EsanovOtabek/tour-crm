<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\GuideCategory;
use App\Models\TourCity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Currency;
use Nnjeim\World\Models\Language;

class GuideController extends Controller
{
    public function index()
    {

        $guides = Guide::all();
        $categories = GuideCategory::all();
        $languages = Language::all();
        $tour_cities = TourCity::all();
        $currencies = Currency::all();

        return view('guides.index', compact('guides', 'categories', 'languages', 'tour_cities', 'currencies'));
    }

    public function store(Request $request)
    {
        $guide = Guide::create($request->only(['name', 'status', 'currency_id', 'guide_category_id', 'tour_city_id', 'price']));
        $guide->languages()->sync($request->languages);
        return redirect()->back()->with('success', 'Guide added!');
    }

    public function update(Request $request, Guide $guide)
    {
        $guide->update($request->only(['name', 'status', 'currency_id', 'guide_category_id', 'tour_city_id', 'price']));
        $guide->languages()->sync($request->languages);
        return redirect()->back()->with('success', 'Guide updated!');
    }
    public function calendar(Request $request)
    {
        // Get month and year from request or use current month/year
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Create Carbon instances for the current, previous and next months
        $currentMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $prevMonth = $currentMonth->copy()->subMonth();
        $nextMonth = $currentMonth->copy()->addMonth();

        // Get all guides with their bookings and related data
        $guides = Guide::with([
            'tour_city',
            'currency',
            'bookingGuides' => function($query) use ($currentMonth) {
                $query->where(function($q) use ($currentMonth) {
                    // Bookings that overlap with the current month
                    $q->whereBetween('start_date', [
                        $currentMonth->copy()->startOfMonth(),
                        $currentMonth->copy()->endOfMonth()
                    ])
                        ->orWhereBetween('end_date', [
                            $currentMonth->copy()->startOfMonth(),
                            $currentMonth->copy()->endOfMonth()
                        ])
                        ->orWhere(function($q) use ($currentMonth) {
                            // Bookings that span the entire month
                            $q->where('start_date', '<', $currentMonth->copy()->startOfMonth())
                                ->where('end_date', '>', $currentMonth->copy()->endOfMonth());
                        });
                })
                    ->with(['booking', 'tourCity']); // Eager load relationships
            }
        ])
            ->orderBy('name')
            ->get();

        // Prepare calendar data for each guide
        $guides->each(function($guide) use ($currentMonth) {
            $guide->calendarDays = collect();

            // Get first and last day of month
            $startDate = $currentMonth->copy()->startOfMonth();
            $endDate = $currentMonth->copy()->endOfMonth();

            // Create days for the current month only
            while ($startDate->lte($endDate)) {
                $day = $startDate->copy();

                // Check if this day is booked for the guide
                $isBooked = $guide->bookingGuides->contains(function($booking) use ($day) {
                    return $day->between($booking->start_date, $booking->end_date);
                });

                // Get bookings for this day if it's booked
                $bookings = $isBooked ? $guide->bookingGuides->filter(function($booking) use ($day) {
                    return $day->between($booking->start_date, $booking->end_date);
                }) : null;

                $guide->calendarDays->push([
                    'date' => $day->format('Y-m-d'),
                    'day' => $day->day,
                    'is_booked' => $isBooked,
                    'weekday' => $day->dayOfWeek, // Store weekday for header
                    'bookings' => $bookings
                ]);

                $startDate->addDay();
            }
        });

        // Generate month/year dropdown options
        $monthOptions = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthOptions[$i] = Carbon::create()->month($i)->translatedFormat('F');
        }

        $yearOptions = range(now()->year - 2, now()->year + 2);

        return view('guides.calendar', [
            'guides' => $guides,
            'currentMonth' => $currentMonth,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
            'monthOptions' => $monthOptions,
            'yearOptions' => $yearOptions,
        ]);
    }
    public function destroy(Guide $guide)
    {
        $guide->delete();
        return redirect()->back()->with('success', 'Guide deleted!');
    }

}
