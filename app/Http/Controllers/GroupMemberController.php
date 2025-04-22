<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Booking;
use App\Models\GroupMember;
use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
    public function index(Booking $booking)
    {
        $booking->load(['groupMembers', 'groupMembers.agent']);
        $agents = Agent::all();
        return view('bookings.group-members', compact('booking', 'agents'));
    }
    public function show(Booking $booking, GroupMember $groupMember)
    {
        return view('bookings.group-member', compact('groupMember', 'booking'));
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
            'agent_id' => 'nullable|exists:agents,id', // Added validation
        ]);


        $booking->groupMembers()->create($validated);

        return redirect()->back()->with('success', 'Group member added successfully.');
    }

    public function update(Request $request, Booking $booking, GroupMember $groupMember)
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
            'agent_id' => 'nullable|exists:agents,id',
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
