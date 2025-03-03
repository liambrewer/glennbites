<?php

namespace App\Http\Requests\Storefront\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AttemptOneTimePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
            'sid' => ['required', 'string'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'code' => str_replace('-', '', $this->code),
        ]);
    }
}
