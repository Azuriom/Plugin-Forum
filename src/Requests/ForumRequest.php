<?php

namespace Azuriom\Plugin\Forum\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
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
        'is_locked',
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
                'required', 'string', 'max:100', new Slug(), Rule::unique(Forum::class)->ignore($this->forum, 'slug')
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:forum_categories,id'],
            'roles' => ['sometimes', 'nullable', 'array'],
            'is_locked' => ['filled', 'boolean'],
        ];
    }

    public function validated()
    {
        $validated = parent::validated();

        $validated['roles'] = $this->filled('is_restricted')
            ? array_keys(Arr::get($validated, 'roles', []))
            : null;

        return $validated;
    }
}
