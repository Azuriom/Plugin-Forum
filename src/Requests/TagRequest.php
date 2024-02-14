<?php

namespace Azuriom\Plugin\Forum\Requests;

use Azuriom\Rules\Color;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'color' => ['required', new Color()],
            'roles' => ['sometimes', 'nullable', 'array'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (! $this->filled('is_restricted') || ! $this->has('roles')) {
            $this->merge(['roles' => null]);
        }
    }
}
