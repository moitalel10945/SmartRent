<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\Unit;
use App\Models\User;

class UnitPolicy
{
    public function viewAny(User $user, Property $property): bool
    {
        return $property->landlord_id === $user->id;
    }

    public function modify(User $user, Unit $unit): bool
    {
        return $unit->property->landlord_id === $user->id;
    }
}