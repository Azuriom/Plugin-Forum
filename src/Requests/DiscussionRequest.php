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
     * The checkboxes attributes.
     *
     * @var array
     */
    protected $checkboxes = [
        'is_pinned', 'is_locked',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
