<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id'  => 'required|exists:users,id',
            'unit_id'    => 'required|exists:units,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
        ];
    }
}