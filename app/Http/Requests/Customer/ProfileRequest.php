<?php

namespace App\Http\Requests\Customer;

use App\Foundations\BaseRequest;

class ProfileRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "identity_number" => "nullable|string|max:255",
            "name"            => "required|string|max:255",
            "email"           => "required|string|email|max:255",
            "phone"           => "required|string|max:255",
            "address"         => "required|string|max:255",
        ];
    }
}
