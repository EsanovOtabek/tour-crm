<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
        return view('finance.expenses', compact('expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'allowed' => 'required|numeric',
            'sub_category' => 'nullable|string',
        ]);

        Expense::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'name' => 'required|string',
            'allowed' => 'required|numeric',
            'sub_category' => 'nullable|string',
        ]);

        $expense->update($request->all());
        return redirect()->back();
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->back();
    }
}
