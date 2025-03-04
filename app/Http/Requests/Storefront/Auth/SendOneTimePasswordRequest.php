<?php

namespace App\Http\Requests\Storefront\Auth;

use App\Rules\LeanderIsdDomain;
use App\Rules\NoEmailPlusAddress;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendOneTimePasswordRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', new NoEmailPlusAddress(), new LeanderIsdDomain()],
        ];
    }
}
