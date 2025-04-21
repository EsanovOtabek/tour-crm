<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\GroupMember;
use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
    public function index(Booking $booking)
    {
        $booking->load('groupMembers');
        return view('bookings.group-members', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'passport_number' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'telegram' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'status' => 'nullable|string|in:active,cancelled,pending',
        ]);

        $booking->groupMembers()->create($validated);

        return redirect()->back()->with('success', 'Group member added successfully.');
    }

    public function update(Request $request, Booking $booking,GroupMember $groupMember)
    {
        $validated = $request->validate([
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'passport_number' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'telegram' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'status' => 'nullable|string|in:active,cancelled,pending',
        ]);

        $groupMember->update($validated);

        return redirect()->back()->with('success', 'Group member updated successfully.');
    }

    public function destroy(Booking $booking, GroupMember $groupMember)
    {
        $groupMember->delete();

        return redirect()->back()->with('success', 'Group member removed successfully.');
    }
}
