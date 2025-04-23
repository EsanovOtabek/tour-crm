<?php
namespace App\Http\Controllers;

use App\Models\BookingExpense;
use App\Models\Booking;
use App\Models\Expense;
use Illuminate\Http\Request;

class BookingExpenseController extends Controller
{
    public function index(Booking $booking)
    {
        $expenses = $booking->expenses;
        $allExpenses = Expense::all();
        return view('bookings.expenses', compact('expenses', 'booking', 'allExpenses'));
    }
    public function store(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'expense_id' => 'required|exists:expenses,id',
        ]);
        $data['user_id'] = auth()->user()->id;

        $booking->expenses()->create($data);
        return redirect()->back()->with('success', 'Expense added successfully.');
    }

    public function update(Request $request, Booking $booking, BookingExpense $expense)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'expense_id' => 'required|exists:expenses,id',
        ]);

        $expense->update($data);
        return redirect()->back()->with('success', 'Expense updated.');
    }

    public function destroy(Booking $booking, BookingExpense $expense)
    {
        $expense->delete();
        return redirect()->back()->with('success', 'Expense deleted.');
    }
}
