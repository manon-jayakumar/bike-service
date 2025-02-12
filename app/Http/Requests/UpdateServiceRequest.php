<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Define validation rules for updating a service.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:services,name,' . $this->route('service')],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:1'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
