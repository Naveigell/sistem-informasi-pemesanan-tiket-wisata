<?php

namespace App\Http\Requests\Admin;

use App\Foundations\BaseRequest;

class GalleryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image|max:' . (1024 * 10), // 10MB
        ];
    }
}
