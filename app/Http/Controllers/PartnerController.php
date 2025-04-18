<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerType;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::with('type')->latest()->paginate(10);
        return view('partners.index', compact('partners'));
    }

    public function create()
    {
        $types = PartnerType::all();
        return view('partners.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'balans' => 'nullable|numeric',
            'type_id' => 'required|exists:partner_types,id',
        ]);

        Partner::create($validated);

        return redirect()->route('partners.index')->with('success', 'Hamkor muvaffaqiyatli qo‘shildi.');
    }

    public function edit(Partner $partner)
    {
        $types = PartnerType::all();
        return view('partners.edit', compact('partner', 'types'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'balans' => 'nullable|numeric',
            'type_id' => 'required|exists:partner_types,id',
        ]);

        $partner->update($validated);

        return redirect()->route('partners.index')->with('success', 'Hamkor yangilandi.');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->route('partners.index')->with('success', 'Hamkor o‘chirildi.');
    }
}

