<?php

namespace App\Http\Controllers;

use App\Models\ObjectItem;
use App\Models\Partner;
use App\Models\PartnerObject;
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
        $selectedPartnerObjectId = $request->query('partner_object_id', null);
        $partners = Partner::all();
        $partnerObjects = PartnerObject::all();

        $query = ObjectItem::query();

        if ($selectedPartnerObjectId) {
            $query->where('partner_object_id', $selectedPartnerObjectId);
            $selectedPartnerObject = PartnerObject::find($selectedPartnerObjectId);
        } else{
            $selectedPartnerObject = null;
        }

        $items = $query->paginate(15);

        return view('partners.items', compact('selectedPartnerObjectId', 'partners','partnerObjects', 'selectedPartnerObject', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric',
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
