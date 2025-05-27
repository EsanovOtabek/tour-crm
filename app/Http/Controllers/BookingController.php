<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Mashrut;
use App\Models\ObjectItem;
use App\Models\Partner;
use App\Models\PartnerObject;
use App\Models\PartnerType;
use App\Models\PriceList;
use App\Models\Tour;
use App\Models\TourCity;
use App\Models\TourTemplate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{

    public function templates()
    {
        $bookings = Booking::where('is_marked', 1)->get();
        $tours = Tour::all();
        $priceList = PriceList::all();

        // If you need to call the recommendedPrice() method for each booking,
        // iterate over the bookings and get the recommended price
        foreach ($bookings as $booking) {
            $booking->recommendedPrice = $booking->getRecommendedPrice(); // Call the new method
        }
        return view('bookings.templates', compact('bookings', 'tours', 'priceList'));

    }

    public function changeMarked(Booking $booking)
    {
        $booking->is_marked = !$booking->is_marked;
        $booking->save();
        return redirect()->back()->with('success', 'Booking marked successfully!');
    }
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

        // If you need to call the recommendedPrice() method for each booking,
        // iterate over the bookings and get the recommended price
        foreach ($bookings as $booking) {
            $booking->recommendedPrice = $booking->getRecommendedPrice(); // Call the new method
        }

        return view('bookings.index', compact('bookings', 'tours', 'priceList'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([

            'tour_id' => 'required|exists:tours,id',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'unique_code' => 'required|unique:bookings,unique_code'

        ]);
        $validated['price'] = 0;
        $validated['cost_price'] = 0;

        // Calculate total_amount based on other fields if needed
        $validated['total_amount'] = $request->input('total_amount', $validated['price']);
        $validated['user_id'] = auth()->user()->id;

        Booking::create($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function copystore(Request $request)
    {
        $tour_id = $request->input('tour_id');
        $tour = Tour::findOrFail($tour_id);
        $tour_template = TourTemplate::where('tour_id', $tour_id)->with(['details', 'mashruts'])->first();

        $booking = new Booking();
        $booking->user_id = auth()->user()->id;
        $booking->tour()->associate($tour);
        $booking->status = $request->input('status');
        $booking->start_date = $request->input('start_date');
        $booking->end_date = $booking->start_date->addDays($tour->day_quantity - 1);
        $booking->unique_code = $request->input('unique_code');
        $booking->total_amount = 0;
        $booking->price = 0;
        $booking->cost_price = 0;
        $booking->save();


        // Apply details
        foreach ($tour_template->details as $detail) {
            $booking->details()->create([
                'object_item_id' => $detail->object_item_id,
                'quantity' => $detail->quantity,
                'price' => $detail->price,
                'cost_price' => $detail->cost_price,
                'start_date' => $booking->start_date->addDays($detail->start_day - 1),
                'end_date' => $booking->start_date->addDays($detail->end_day - 1),
                'user_id' => auth()->id(),
                'comment' => $detail->comment,
            ]);
        }

        // Apply mashruts
        foreach ($tour_template->mashruts as $mashrut) {
            $booking->mashruts()->create([
                'tour_city_id' => $mashrut->tour_city_id,
                'date_time' => $booking->start_date->addDays($mashrut->day_number - 1),
                'program' => $mashrut->program,
                'order_no' => $mashrut->order_no,
            ]);
        }

        return back()->with('success', 'Template applied to booking successfully.');
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
            'unique_code' => [
                'required',
                Rule::unique('bookings', 'unique_code')->ignore($booking->id),
            ],
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

    public function showCopyModal()
    {
        // Templatelar va oxirgi 10 ta buyurtmani ko'rsatamiz
        $templates = Booking::where('is_template', true)->latest()->take(10)->get();
        $recentBookings = Booking::where('is_template', false)->latest()->take(10)->get();

        return view('bookings.copy-modal', compact('templates', 'recentBookings'));
    }

    public function copyFromTemplate(Booking $booking)
    {
        return $this->prepareCopyView($booking);
    }

    public function copyFromBooking(Booking $booking)
    {
        return $this->prepareCopyView($booking);
    }

    protected function prepareCopyView(Booking $booking)
    {
        // Original booking ma'lumotlari
        $originalDetails = $booking->details;
        $originalMashruts = $booking->mashruts;

        $tours = Tour::all();
        $objectItems = ObjectItem::all();
        $tourCities = TourCity::all();

        $partnerTypes = PartnerType::all();
        $partners = Partner::all();
        $partnerObjects = PartnerObject::all();
        return view('bookings.copy', compact('booking', 'originalDetails', 'originalMashruts', 'tours', 'objectItems', 'tourCities', 'partnerTypes', 'partners', 'partnerObjects', ));
    }

    public function storeCopy(Request $request)
    {
        $old_booking = Booking::findOrFail($request->old_booking_id);
        // Asosiy booking ma'lumotlarini saqlaymiz
        $booking = new Booking($request->only([
            'tour_id', 'status', 'price', 'unique_code', 'start_date', 'end_date'
        ]));

        $booking->total_amount = 0;
        $booking->cost_price = 0;
        $booking->is_marked = 0;
        $booking->user_id = auth()->id();
        $booking->save();

        // Detallarni saqlaymiz
        foreach ($request->details as $detail) {
            $newDetail = new BookingDetail([
                'object_item_id' => $detail['object_item_id'],
                'quantity' => $detail['quantity'],
                'price' => $detail['price'],
                'cost_price' => $detail['cost_price'],
                'start_date' => $detail['start_date'],
                'end_date' => $detail['end_date'],
                'user_id' => auth()->id(),
                'comment' => $detail['comment'],
            ]);

            $booking->details()->save($newDetail);
        }

        // Mashrutlarni saqlaymiz
        foreach ($request->mashruts as $mashrut) {
            $newMashrut = new Mashrut([
                'tour_city_id' => $mashrut['tour_city_id'],
                'date_time' => $mashrut['date_time'],
                'program' => $mashrut['program'],
                'order_no' => $mashrut['order_no'],
            ]);

            $booking->mashruts()->save($newMashrut);
        }

        return redirect()->route('bookings.index', $booking->id)
            ->with('success', 'Buyurtma muvaffaqiyatli nusxalandi!');
    }
}
