<?php

namespace App\Http\Requests\Customer;

use App\Foundations\BaseRequest;

class TicketRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "customer_name"  => "required|string|max:255",
            "customer_email" => "required|string|max:150|email",
            "customer_phone" => "required|string|digits_between:3,17",
            "booking_date"   => "required|date|after:" . now()->format('Y-m-d'),

            "total_tickets"  => "required|integer|gte:1",
            "ticket_ids"     => "required|array",
            "ticket_ids.*"   => "required|exists:tickets,id",
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->request->add([
            "total_tickets" => collect($this->tickets)->sum(),
            "ticket_ids"    => collect($this->tickets)->keys()->toArray(),
        ]);
    }
}
