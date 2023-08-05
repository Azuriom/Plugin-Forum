<?php

namespace Azuriom\Plugin\Forum\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'display_last_seen',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'about' => ['nullable', 'string'],
            'signature' => ['nullable', 'string', 'max:500'],
            'website' => ['nullable', 'string', 'url', 'max:100'],
            'location' => ['nullable', 'string', 'max:50'],
            'discord' => ['nullable', 'string', 'max:40', 'regex:/^(@[\w.]{2,32})|(.+#\d{4})$/'],
            'twitter' => ['nullable', 'string', 'max:15', 'alpha_dash', 'regex:/^[A-Za-z0-9_]+$/'],
            'display_last_seen' => ['filled', 'boolean'],
        ];
    }
}
