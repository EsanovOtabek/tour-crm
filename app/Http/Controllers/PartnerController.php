<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerObject;
use App\Models\PartnerType;
use App\Models\TourCity;
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
        $selectedPartnerTypeId = $request->query('type_id', null);

        $partnerTypes = PartnerType::all();
        $partners = Partner::when($selectedPartnerTypeId, function($query) use ($selectedPartnerTypeId) {
            return $query->where('type_id', $selectedPartnerTypeId);
        })->get();

        $query = PartnerObject::query();

        if ($selectedPartnerId) {
            $query->where('partner_id', $selectedPartnerId);
            $selectedPartner = Partner::find($selectedPartnerId);
        } else {
            $selectedPartner = null;
        }

        $partnerObjects = $query->with(['city','partner'])->get();

        $tourCities = TourCity::all();
        return view('partners.objects', compact(
            'partnerObjects',
            'partners',
            'partnerTypes',
            'selectedPartner',
            'selectedPartnerId',
            'selectedPartnerTypeId',
            'tourCities'
        ));
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

