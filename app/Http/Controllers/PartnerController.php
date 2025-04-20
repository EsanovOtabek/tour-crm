<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerObject;
use App\Models\PartnerType;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    protected function middleware(): array
    {
        return [
            'permission:partners.index' => ['only' => ['index']],
            'permission:partners.store' => ['only' => ['store']],
            'permission:partners.show' => ['only' => ['show']],
            'permission:partners.update' => ['only' => ['update']],
            'permission:partners.destroy' => ['only' => ['destroy']],
        ];
    }
    public function index()
    {
        $partners = Partner::with('type')->latest()->paginate(10);
        $partnerTypes = PartnerType::all();
        return view('partners.index', compact('partners', 'partnerTypes'));
    }

    public function show(Request $request)
    {
        $selectedPartnerId = $request->query('partner_id', null);
        $partners = Partner::all();

        $query = PartnerObject::query();

        if ($selectedPartnerId) {
            $query->where('partner_id', $selectedPartnerId);
            $selectedPartner = Partner::find($selectedPartnerId);
        } else {
            $selectedPartner = null;
        }

        $partnerObjects = $query->paginate(15);

        return view('partners.objects', compact('partnerObjects', 'partners', 'selectedPartner', 'selectedPartnerId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:partner_types,id',
        ]);

        Partner::create($validated);

        return redirect()->route('partners.index')->with('success', 'Hamkor muvaffaqiyatli qo‘shildi.');
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

