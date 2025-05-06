<?php

namespace App\Http\Controllers;

use App\Models\ObjectItem;
use App\Models\Partner;
use App\Models\PartnerObject;
use App\Models\PartnerType;
use Nnjeim\World\Models\Currency;
use Illuminate\Http\Request;

class ObjectItemController extends Controller
{
    protected function middleware(): array
    {
        return [
            'permission:object-items.index' => ['only' => ['index']],
            'permission:object-items.store' => ['only' => ['store']],
            'permission:object-items.update' => ['only' => ['update']],
            'permission:object-items.destroy' => ['only' => ['destroy']],
        ];
    }

    public function index(Request $request)
    {
        $selectedPartnerTypeId = $request->query('partner_type_id', null);
        $selectedPartnerId = $request->query('partner_id', null);
        $selectedPartnerObjectId = $request->query('partner_object_id', null);

        $partnerTypes = PartnerType::all();
        $partners = Partner::when($selectedPartnerTypeId, function($query) use ($selectedPartnerTypeId) {
            return $query->where('type_id', $selectedPartnerTypeId);
        })->get();

        $partnerObjects = PartnerObject::when($selectedPartnerId, function($query) use ($selectedPartnerId) {
            return $query->where('partner_id', $selectedPartnerId);
        })->get();

        $currencies = Currency::all();

        $query = ObjectItem::query()
            ->with(['partnerObject.partner.type', 'partnerObject.partner', 'currency']);

        if ($selectedPartnerObjectId) {
            $query->where('partner_object_id', $selectedPartnerObjectId);
        } elseif ($selectedPartnerId) {
            $query->whereHas('partnerObject', function($q) use ($selectedPartnerId) {
                $q->where('partner_id', $selectedPartnerId);
            });
        } elseif ($selectedPartnerTypeId) {
            $query->whereHas('partnerObject.partner', function($q) use ($selectedPartnerTypeId) {
                $q->where('type_id', $selectedPartnerTypeId);
            });
        }

        $items = $query->get();

        return view('partners.items', compact(
            'selectedPartnerTypeId',
            'selectedPartnerId',
            'selectedPartnerObjectId',
            'partnerTypes',
            'partners',
            'partnerObjects',
            'currencies',
            'items'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'currency_id' => 'required|exists:currencies,id',
            'partner_object_id' => 'required|exists:partner_objects,id',
        ]);

        ObjectItem::create($request->all());
        return back()->with('success', 'Object item created successfully.');
    }

    public function update(Request $request, ObjectItem $objectItem)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'currency_id' => 'required|exists:currencies,id',
            'partner_object_id' => 'required|exists:partner_objects,id',
        ]);

        $objectItem->update($request->all());
        return back()->with('success', 'Object item updated successfully.');
    }

    public function destroy(ObjectItem $objectItem)
    {
        $objectItem->delete();
        return back()->with('success', 'Object item deleted successfully.');
    }
}
