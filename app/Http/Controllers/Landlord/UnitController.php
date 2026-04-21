<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Property;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index(Property $property)
    {
        $this->authorize('viewAny', [Unit::class, $property]);
        $units = $property->units;
        return view('landlord.units.index', compact('property', 'units'));
    }

    public function create(Property $property)
    {
        abort_if($property->landlord_id !== auth()->id(), 403);
        return view('landlord.units.create', compact('property'));
    }

    public function store(StoreUnitRequest $request, Property $property)
    {
        abort_if($property->landlord_id !== auth()->id(), 403);
        $property->units()->create($request->validated());
        return redirect()
            ->route('landlord.properties.units.index', $property)
            ->with('success', 'Unit created successfully.');
    }

    public function edit(Property $property, Unit $unit)
    {
        $this->authorize('modify', $unit);
        abort_if($unit->property_id !== $property->id, 404);
        return view('landlord.units.edit', compact('property', 'unit'));
    }

    public function update(UpdateUnitRequest $request, Property $property, Unit $unit)
    {
        $this->authorize('modify', $unit);
        abort_if($unit->property_id !== $property->id, 404);
        $unit->update($request->validated());
        return redirect()
            ->route('landlord.properties.units.index', $property)
            ->with('success', 'Unit updated successfully.');
    }

    public function destroy(Property $property, Unit $unit)
    {
        $this->authorize('modify', $unit);
        abort_if($unit->property_id !== $property->id, 404);
        $unit->delete();
        return back()->with('success', 'Unit deleted.');
    }
}