<?php

namespace App\Http\Requests\Server;

use Illuminate\Foundation\Http\FormRequest;

final class StoreServerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'ip_address' => 'nullable|string|max:45',
        ];
    }
}
