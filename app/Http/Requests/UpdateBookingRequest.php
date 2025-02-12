<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Define validation rules for updating a booking.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'booking_date' => ['required', 'date'],
            'notes' => ['nullable'],
            'status' => ['required', 'string', 'in:pending,ready for delivery,completed'],
        ];
    }
}
