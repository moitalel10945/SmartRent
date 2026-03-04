<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function authorizeProperty(Property $property){
        if($property->user_id !==auth()->id()){
            abort(403);
        }
    }
    public function index(Property $propety)
    {
        
        $this->authorizeProperty($propety);
        $units=$property->units();
        return view('landlord.units.index', compact('property', 'units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Property $property)
    {
        $this->authorizeProperty($property);
        return view('landlord.units.create', compact('property'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeProperty($property); 
        
        $validated = $request->validate([
            'unit_number' => 'required|string',
            'rent_amount' => 'required|numeric|min:0',
            'status' => 'required|in:vacant,occupied',
        ]);
        $property->units()->create($validated);
         return redirect()
        ->route('landlord.properties.units.index', $property)
        ->with('success', 'Unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property, Unit $unit)
    {
        $this->authorizeProperty($property);
        abort_if($unit->property_id !== $property->id, 404);
        return view('landlord.units.edit', compact('property', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
