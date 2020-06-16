<?php

namespace Azuriom\Plugin\Forum\Requests;

use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ForumRequest extends FormRequest
{
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
        ];
    }
}
