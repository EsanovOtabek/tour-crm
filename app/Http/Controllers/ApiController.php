<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerObject;
use App\Models\ObjectItem;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function get_all_partners(Request $request)
    {
        // If type_id is provided as a query parameter, filter by type
        if ($request->has('type_id')) {
            $partners = Partner::where('type_id', $request->type_id)->get();
        } else {
            $partners = Partner::all();
        }
        return response()->json($partners);
    }

    public function get_partners_by_type($typeId)
    {
        $partners = Partner::where('type_id', $typeId)->get();
        return response()->json($partners);
    }

    public function get_partner_objects(Request $request)
    {
        // Check if partner_id is provided as a query parameter
        if ($request->has('partner_id')) {
            $partnerObjects = PartnerObject::where('partner_id', $request->partner_id)->get();
            return response()->json($partnerObjects);
        }

        // Return all partner objects if no partner_id is provided
        return response()->json(PartnerObject::all());
    }

    public function get_partner_objects_by_partner($partnerId)
    {
        $partnerObjects = PartnerObject::where('partner_id', $partnerId)->get();
        return response()->json($partnerObjects);
    }

    public function get_object_items(Request $request)
    {
        // Check if object_id is provided as a query parameter
        if ($request->has('object_id')) {
            $objectItems = ObjectItem::where('partner_object_id', $request->object_id)->get();
            return response()->json($objectItems);
        }

        // Return all object items if no object_id is provided
        return response()->json(ObjectItem::all());
    }

    public function get_object_items_by_object($objectId)
    {
        $objectItems = ObjectItem::where('partner_object_id', $objectId)->get();
        return response()->json($objectItems);
    }
}
