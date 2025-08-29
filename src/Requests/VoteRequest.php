<?php

namespace Azuriom\Plugin\Forum\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'options' => ['required', 'array', 'min:1'],
            'options.*' => ['required', 'integer', 'exists:forum_poll_options,id'],
        ];
    }
}
