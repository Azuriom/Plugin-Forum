<?php

namespace Azuriom\Plugin\Forum\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ForumRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'is_locked', 'is_private',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:50'],
            'slug' => [
                'required', 'string', 'max:100', new Slug(), Rule::unique(Forum::class)->ignore($this->forum, 'slug'),
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:forum_categories,id'],
            'parent_id' => ['nullable', 'exists:forum_forums,id'],
            'roles' => ['sometimes', 'nullable', 'array'],
            'default_tags' => ['sometimes', 'nullable', 'array'],
            'is_locked' => ['filled', 'boolean'],
            'is_private' => ['filled', 'boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->mergeCheckboxes();

        if (! $this->filled('is_restricted') || ! $this->has('roles')) {
            $this->merge(['roles' => null]);
        }

        if (! $this->has('default_tags')) {
            $this->merge(['default_tags' => null]);
        }
    }
}
