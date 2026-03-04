<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     private function authorizeProperty(Property $property)
{
    if ($property->landlord_id !== auth()->id()) {
        abort(403);
    }
}
    public function index()
    {
      $properties=auth()->user()->properties()->latest()->get(); 
      return view('landlord.properties.index',compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('landlord.properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated= $request->validate([
            'name'=>'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
        auth()->user()->properties()->create($validated);
        return redirect()->route('landlord.properties.index')
        ->with('success', 'Property created successfully.');
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
    public function edit(Property $property)
    {
        $this->authorizeProperty($property);
        return view('landlord.properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $this->authorizeProperty($property);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $property->update($validated);

    return redirect()->route('landlord.properties.index')
        ->with('success', 'Property updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $this->authorizeProperty($property);

    $property->delete();

    return redirect()->route('landlord.properties.index')
        ->with('success', 'Property deleted.');
    }
}
