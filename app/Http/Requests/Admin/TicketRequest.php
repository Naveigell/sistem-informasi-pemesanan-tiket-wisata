<?php

namespace App\Http\Requests\Admin;

use App\Enums\TicketGroupEnum;
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
        $groups = collect(TicketGroupEnum::cases())->map(fn ($item) => $item->value);

        return [
            "name"        => "required|string|max:100",
            "ticket_code" => "required|string|max:15",
            "group"       => "required|string|in:" . $groups->join(','),
            "price"       => "required|numeric|min:0|max:999999", // max: 999.999
        ];
    }
}
