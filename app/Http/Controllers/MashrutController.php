<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mashrut;
use App\Models\TourCity;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MashrutController extends Controller
{
    public function index(Booking $booking)
    {
        $mashruts = $booking->mashruts()->with('tourCity')->orderBy('order_no')->get();
        $tourCities = TourCity::all(); // Dropdown uchun

        return view('bookings.mashruts', compact('mashruts', 'booking', 'tourCities'));
    }

    public function store(Request $request, Booking $booking)
    {
        $request->validate([
            'tour_city_id' => 'required|exists:tour_cities,id',
            'date_time' => 'required|date',
            'program' => 'nullable|string',
            // 'order_no' => 'required|integer', // endi kerak emas
        ]);

        // Avtomatik tartib raqamini aniqlash
        $nextOrderNo = $booking->mashruts()->max('order_no') + 1;

        $booking->mashruts()->create([
            'tour_city_id' => $request->tour_city_id,
            'date_time' => $request->date_time,
            'program' => $request->program,
            'order_no' => $nextOrderNo,
        ]);


        return redirect()->back()->with('success', 'Mashrut qo‘shildi.');
    }
    public function downloadPdf(Booking $booking)
    {
        $mashruts = $booking->mashruts()->with('tourCity')->orderBy('order_no')->get();

        $pdf = Pdf::loadView('pdf.mashrut', [
            'booking' => $booking,
            'mashruts' => $mashruts
        ]);

        return $pdf->download('mashrut_booking_' . $booking->id . '.pdf');
    }


    public function update(Request $request, Booking $booking, Mashrut $mashrut)
    {
        $request->validate([
            'tour_city_id' => 'required|exists:tour_cities,id',
            'date_time' => 'required|date',
            'program' => 'nullable|string',
            'order_no' => 'required|integer',
        ]);

        $mashrut->update([
            'tour_city_id' => $request->tour_city_id,
            'date_time' => $request->date_time,
            'program' => $request->program,
            'order_no' => $request->order_no,
        ]);

        return redirect()->back()->with('success', 'Mashrut yangilandi.');
    }

    public function destroy(Booking $booking, Mashrut $mashrut)
    {
        $mashrut->delete();
        return redirect()->back()->with('success', 'Mashrut o‘chirildi.');
    }
}
