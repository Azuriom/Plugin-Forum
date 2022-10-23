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
     * The checkboxes attributes.
     *
     * @var array
     */
    protected $checkboxes = [
        'is_locked', 'is_private',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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

    public function validated($key = null, $value = null)
    {
        $validated = parent::validated();

        if (! $this->filled('is_restricted') || ! array_key_exists('roles', $validated)) {
            $validated['roles'] = null;
        }

        if (! array_key_exists('default_tags', $validated)) {
            $validated['default_tags'] = null;
        }

        return $validated;
    }
}
