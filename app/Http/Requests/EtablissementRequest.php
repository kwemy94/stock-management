<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtablissementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:60|unique:etablissements,email',
            'phone' => 'nullable|string|max:50',
            'activity' => 'nullable|string|max:50',
            'logo' => 'nullable|image|max:2048',
            'taxpayer_number' => 'nullable|string|unique:etablissements,taxpayer_number',
            'trade_register_number' => 'nullable|string|unique:etablissements,trade_register_number',
        ];
    }
}
