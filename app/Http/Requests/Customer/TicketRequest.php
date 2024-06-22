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
        $rules = [
            "booking_date"   => "required|date|after:" . now()->format('Y-m-d'),

            "total_tickets"  => "required|integer|gte:1", // if total tickets is more than 0, it's mean customer already order ticket
            "ticket_ids"     => "required|array",
            "ticket_ids.*"   => "required|exists:tickets,id",
            "tickets"        => "required|array",
            "tickets.*"      => "required|integer|gte:0", // it's okay if ticket quantity is 0, because `total_tickets` already validate it
        ];

        // if customer is not logged in, we need to get customer name, email and phone
        // otherwise, we can use the customer name, email and phone from users table
        if (!optional(auth()->user())->isCustomer()) {
            return array_merge($rules, [
                "identity_number" => "nullable|string|numeric|max_digits:20|min_digits:0",
                "customer_name"   => "required|string|max:255",
                "customer_email"  => "required|string|max:150|email",
                "customer_phone"  => "required|string|digits_between:3,17",
            ]);
        }

        return $rules;
    }

    /**
     * Get the total number of tickets.
     *
     * @return int
     */
    public function getTotalTickets()
    {
        return collect($this->tickets)->sum();
    }

    /**
     * Get total ticket by id
     *
     * @param int $id The id of the ticket
     * @return mixed|null The total ticket or null if not found
     */
    public function getTotalTicketById($id)
    {
        return $this->tickets[$id] ?? null;
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
            "ticket_ids"    => collect($this->tickets)
                ->filter(fn($value) => $value > 0) // we only need ticket id's if ticket quantity is more than 0
                ->keys()
                ->toArray(),
        ]);
    }
}
