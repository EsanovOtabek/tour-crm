<?php

namespace App\Http\Controllers;

use App\Models\PartnerType;
use Illuminate\Http\Request;

class PartnerTypeController extends Controller
{
    protected function middleware(): array
    {
        return [
            'permission:partner-type.index' => ['only' => ['index']],
            'permission:partner-type.store' => ['only' => ['store']],
            'permission:partner-type.update' => ['only' => ['update']],
            'permission:partner-type.destroy' => ['only' => ['destroy']],
        ];
    }

    public function index()
    {
        $types = PartnerType::all();
        return view('partners.types', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        PartnerType::create(['name' => $request->name]);

        return back()->with('success', 'Turi qo‘shildi.');
    }

    public function update(Request $request, PartnerType $partnerType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $partnerType->update($validated);

        return back()->with('success', 'Yangilandi!');
    }

    public function destroy(PartnerType $partnerType)
    {
        $partnerType->delete();

        return back()->with('success', 'O‘chirildi!');
    }



}
