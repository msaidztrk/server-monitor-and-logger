<?php

namespace App\Http\Requests\Server;

use Illuminate\Foundation\Http\FormRequest;

final class StoreMetricRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cpu_usage' => 'required|numeric|min:0|max:100',
            'ram_usage' => 'required|numeric|min:0|max:100',
            'disk_usage' => 'required|numeric|min:0|max:100',
        ];
    }
}
