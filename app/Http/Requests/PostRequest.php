<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'min:5'],
            'summary' => ['required'],
            'content' => ['nullable', 'min:5'],
            'thumbnail' => ['required', 'mimes:png,jpg,jpeg'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
        ];
    }

    public function getData()
    {
        return array_merge($this->validated(), [
            'thumbnail' => $this->hasFile('thumbnail') ? $this->file('thumbnail')->store('thumbnail') : null,
        ]);
    }
}
