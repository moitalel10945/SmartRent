<?php

namespace App\Policies;

use App\Models\Tenancy;
use App\Models\User;

class TenancyPolicy
{
    public function view(User $user, Tenancy $tenancy): bool
    {
        return $tenancy->unit->property->landlord_id === $user->id;
    }

    public function modify(User $user, Tenancy $tenancy): bool
    {
        return $tenancy->unit->property->landlord_id === $user->id;
    }
}