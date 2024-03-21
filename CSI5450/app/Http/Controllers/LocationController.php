<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    //
    public function store(Request $request) {
        $request->validate([
            'identificationNumber' => 'required|unique:locations',
            'addressLine1' => 'required',
            'city' => 'required',
            'zipCode' => 'required',
            'county' => 'required',
            // 'unitNumber' is required only if addressLine1 is same as an existing record
        ]);

        $location = Location::create($request->all());

        return response()->json($location, 201);
    }
}
