<?php

namespace App\Http\Requests\Admin;

use App\Foundations\BaseRequest;

class TestimonialRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"        => "required|string|min:1|max:30",
            "description" => "required|string|min:5|max:10000",
        ];
    }
}
