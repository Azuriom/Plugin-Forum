<?php

namespace Azuriom\Plugin\Forum\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Azuriom\Plugin\Forum\Models\Forum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscussionRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'is_pinned', 'is_locked',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'content' => ['required', 'nullable', 'string'],
            'forum_id' => ['filled', 'nullable', Rule::exists(Forum::class, 'id')],
            'is_pinned' => ['filled', 'boolean'],
            'is_locked' => ['filled', 'boolean'],
        ];
    }
}
