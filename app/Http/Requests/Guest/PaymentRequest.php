<?php

namespace App\Http\Requests\Guest;

use App\Foundations\BaseRequest;

class PaymentRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "payment" => "required|image|mimes:jpeg,png,jpg|max:" . (1024 * 6), // 6 MB
        ];
    }
}
