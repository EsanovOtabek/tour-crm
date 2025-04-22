<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;
use Nnjeim\World\Models\Currency;

class BalanceController extends Controller
{
    public function index()
    {
        $balances = Balance::with('currency')->get();
        $currencies = Currency::all();
        return view('finance.balances', compact('balances','currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric'
        ]);

        Balance::create($request->all());
        return redirect()->back()->with('message', 'succesfully added' );
    }

    public function update(Request $request, Balance $balance)
    {
        $request->validate([
            'name' => 'required',
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric'
        ]);

        $balance->update($request->all());
        return redirect()->back()->with('message', 'succesfully updated' );
    }

    public function destroy(Balance $balance)
    {
        $balance->delete();
        return redirect()->back()->with('message', 'succesfully deletd' );
    }
}
