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
        'is_pinned', 'is_locked', 'multiple_choice', 'results_before_vote', 'remove_vote',
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
            'question' => ['required_with:poll', 'nullable', 'string', 'max:150'],
            'options' => ['required_with:poll', 'nullable', 'array', 'min:2', 'max:10'],
            'multiple_choice' => ['sometimes', 'boolean'],
            'results_before_vote' => ['sometimes', 'boolean'],
            'remove_vote' => ['sometimes', 'boolean'],
            'closes_at' => ['nullable', 'date', 'after:now'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->mergeCheckboxes();

        if (! $this->filled('poll')) {
            $this->merge([
                'question' => null,
                'options' => null,
                'closes_at' => null,
            ]);

            return;
        }

        if (is_array($options = $this->input('options'))) {
            $this->merge(['options' => array_filter($options)]);
        }
    }
}
