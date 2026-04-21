<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $unitId = $this->route('unit')?->id;
        return [
            'unit_number' => [
                'required',
                'string',
                Rule::unique('units')
                    ->where('property_id', $this->route('property')->id)
                    ->ignore($unitId),
            ],
            'rent_amount' => 'required|numeric|min:1',
            'status'      => 'required|in:vacant,occupied',
        ];
    }
}