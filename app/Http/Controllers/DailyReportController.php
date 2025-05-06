<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DailyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyReportController extends Controller
{
    public function index(Request $request)
    {
        // Get the date from the request or use today's date
        $selectedDate = $request->has('date')
            ? Carbon::parse($request->date)
            : Carbon::today();

        // Get active bookings for the selected date
        $activeBookings = Booking::where('status', '!=', 'canceled')
            ->where('start_date', '<=', $selectedDate)
            ->where('end_date', '>=', $selectedDate)
            ->with([
                'tour',
                'dailyReports' => function($query) use ($selectedDate) {
                    $query->whereDate('created_at', $selectedDate);
                },
                'guides' => function($query) use ($selectedDate) {
                    $query->where('start_date', '<=', $selectedDate)
                        ->where('end_date', '>=', $selectedDate)
                        ->with('guide');
                },
                'details' => function($query) use ($selectedDate) {
                    $query->where('start_date', '<=', $selectedDate)
                        ->where('end_date', '>=', $selectedDate)
                        ->with(['objectItem.partnerObject.partner.type' => function($query) {
                            $query->where('name', 'Hotels');
                        }]);
                }
            ])
            ->get();

        return view('daily-reports', compact('activeBookings', 'selectedDate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'selected_bookings' => 'required|array',
            'selected_bookings.*' => 'exists:bookings,id',
            'problem' => 'required|string',
            'solve' => 'nullable|string',
        ], [
            'selected_bookings.required' => 'Kamida bitta buyurtma tanlash kerak',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->selected_bookings as $bookingId) {
                DailyReport::create([
                    'booking_id' => $bookingId,
                    'problem' => $request->problem,
                    'solve' => $request->solve,
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Kunlik hisobotlar muvaffaqiyatli saqlandi');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage())->withInput();
        }
    }

    public function getAgents(Request $request)
    {
        $bookingIds = $request->input('booking_ids', []);
        $date = $request->input('date');

        $agents = [];

        // Get all bookings with their group members
        $bookings = Booking::with(['groupMembers.agent'])
            ->whereIn('id', $bookingIds)
            ->get();

        foreach ($bookings as $booking) {
            foreach ($booking->groupMembers as $member) {
                if ($member->agent && $member->agent->email) {
                    $agents[] = [
                        'name' => $member->agent->name,
                        'email' => $member->agent->email,
                        'booking_code' => $booking->unique_code
                    ];
                }
            }
        }

        // Remove duplicates
        $uniqueAgents = collect($agents)->unique('email')->values()->all();

        return response()->json(['agents' => $uniqueAgents]);
    }

    public function sendEmails(Request $request)
    {
        $request->validate([
            'agent_emails' => 'required|array',
            'agent_emails.*' => 'email',
            'subject' => 'required|string',
            'message' => 'required|string',
            'date' => 'required|date'
        ]);

        $emails = $request->input('agent_emails');
        $subject = $request->input('subject');
        $message = $request->input('message');

        try {
            foreach ($emails as $email) {
                Mail::to($email)->send(new DailyReportMail($subject, $message));
            }

            return redirect()->back()->with('success', 'Emaillar muvaffaqiyatli jo\'natildi!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Email jo\'natishda xatolik: ' . $e->getMessage());
        }
    }
}
