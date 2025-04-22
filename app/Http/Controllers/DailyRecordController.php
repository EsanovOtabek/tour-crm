<?php

namespace App\Http\Controllers;

use App\Models\DailyRecord;
use App\Models\Booking;
use App\Models\GroupMember;
use Illuminate\Http\Request;

class DailyRecordController extends Controller
{
    /**
     * Store a newly created daily record in storage.
     */
    public function store(Request $request)
    {
        $groupMemberId = $request->group_member_id;
        $groupMember = GroupMember::findOrFail($groupMemberId);

        $validated = $request->validate([
            'group_member_id' => 'required|exists:group_members,id',
            'day' => 'required|date',
            'comment' => 'nullable|string',
            'problem' => 'nullable|string',
            'solve' => 'nullable|string',
        ]);

        $dailyRecord = new DailyRecord([
            'day' => $validated['day'],
            'comment' => $validated['comment'],
            'problem' => $validated['problem'],
            'solve' => $validated['solve'],
            'booking_id' => $groupMember->booking_id,
            'group_member_id' => $groupMember->id,
        ]);

        $dailyRecord->save();

        return redirect()->back()->with('success', 'Daily record added successfully.');
    }

    public function update(Request $request, DailyRecord $dailyRecord)
    {
        $groupMemberId = $request->group_member_id;
        $groupMember = GroupMember::findOrFail($groupMemberId);

        $validated = $request->validate([
            'group_member_id' => 'required|exists:group_members,id',
            'day' => 'required|date',
            'comment' => 'nullable|string',
            'problem' => 'nullable|string',
            'solve' => 'nullable|string',
        ]);

        $dailyRecord->update($validated);

        return redirect()->back()->with('success', 'Daily record updated successfully.');
    }

    /**
     * Remove the specified daily record from storage.
     */
    public function destroy(Booking $booking, GroupMember $groupMember, DailyRecord $dailyRecord)
    {
        $dailyRecord->delete();

        return redirect()->back()->with('success', 'Daily record deleted successfully.');
    }
}
