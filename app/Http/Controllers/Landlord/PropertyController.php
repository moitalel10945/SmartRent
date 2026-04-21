<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = auth()->user()->properties()->latest()->get();
        return view('landlord.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('landlord.properties.create');
    }

    public function store(StorePropertyRequest $request)
    {
        auth()->user()->properties()->create($request->validated());
        return redirect()->route('landlord.properties.index')
            ->with('success', 'Property created successfully.');
    }

    public function show(Property $property)
    {
        $this->authorize('view', $property);
        $property->load('units');
        return view('landlord.properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $this->authorize('update', $property);
        return view('landlord.properties.edit', compact('property'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $this->authorize('update', $property);
        $property->update($request->validated());
        return redirect()->route('landlord.properties.index')
            ->with('success', 'Property updated.');
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        $property->delete();
        return redirect()->route('landlord.properties.index')
            ->with('success', 'Property deleted.');
    }
}