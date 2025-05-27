<?php

namespace App\Http\Controllers;

use App\Mail\DailyReportMail;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\DailyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

        $bookingIds = $activeBookings->pluck('id')->toArray();
        $agents = $this->getAllAgents($bookingIds);

        return view('daily-reports', compact('activeBookings', 'selectedDate', 'agents'));
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
            $today = now()->toDateString(); // Get current date (without time)

            foreach ($request->selected_bookings as $bookingId) {
                // Try to find existing report for today for this booking
                $existingReport = DailyReport::where('booking_id', $bookingId)
                    ->whereDate('created_at', $today)
                    ->first();

                if ($existingReport) {
                    // Update existing report
                    $existingReport->update([
                        'problem' => $request->problem,
                        'solve' => $request->solve,
                        'updated_at' => now(),
                    ]);
                } else {
                    // Create new report
                    DailyReport::create([
                        'booking_id' => $bookingId,
                        'problem' => $request->problem,
                        'solve' => $request->solve,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Kunlik hisobotlar muvaffaqiyatli saqlandi');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage())->withInput();
        }
    }

    public function getAllAgents($bookingIds)
    {
        $agents = [];

        // Get all bookings with their group members
        $bookings = Booking::with(['groupMembers.agent'])
            ->whereIn('id', $bookingIds)
            ->get();

        foreach ($bookings as $booking) {
            foreach ($booking->groupMembers as $member) {
                if ($member->agent && $member->agent->email) {
                    $agents[] = [
                        'id' => $member->agent->id,
                        'name' => $member->agent->name,
                        'email' => $member->agent->email,
                        'booking_code' => $booking->unique_code
                    ];
                }
            }
        }

        return collect($agents)->unique('email')->values()->all();
    }


    public function sendEmails(Request $request)
    {
        $request->validate([
            'recipients' => 'required|array',
            'recipients.*' => 'exists:agents,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'date' => 'required|date',
            'include_table' => 'sometimes|boolean'
        ]);

        $date = Carbon::parse($request->date);
        $subject = $request->subject;
        $baseMessage = $request->message;
        $includeTable = $request->boolean('include_table', true);

        foreach ($request->recipients as $agentId) {
            $agent = Agent::findOrFail($agentId);

            // Get bookings for this agent for the selected date
            $bookings = Booking::where('agent_id', $agentId)
                ->whereHas('dailyReports', function($query) use ($date) {
                    $query->whereDate('created_at', $date);
                })
                ->with([
                    'tour',
                    'guides.guide',
                    'details.objectItem.partnerObject.city',
                    'groupMembers',
                    'dailyReports' => function($query) use ($date) {
                        $query->whereDate('created_at', $date);
                    }
                ])
                ->get();

            // Send email to agent
            Mail::to($agent->email)->send(new DailyReportMail(
                $subject,
                $agent,
                $date,
                $includeTable ? $bookings : collect(),
                $baseMessage
            ));
        }

        return redirect()->back()->with('success', 'Email xabarlari muvaffaqiyatli jo\'natildi!');
    }
}
