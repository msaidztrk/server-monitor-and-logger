<?php

namespace App\Http\Requests\Server;

use Illuminate\Foundation\Http\FormRequest;

final class StoreLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'level' => 'required|string|in:debug,info,warning,error,critical',
            'message' => 'required|string',
        ];
    }
}
