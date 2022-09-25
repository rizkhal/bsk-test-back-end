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
            'thumbnail' => ['mimes:png,jpg,jpeg', $this->isStore() ? 'required' : 'nullable'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
        ];
    }

    protected function isUpdate(): bool
    {
        return $this->method() == 'PUT';
    }

    protected function isStore(): bool
    {
        return $this->method() == 'POST';
    }

    public function getData()
    {
        $file = $this->hasFile('thumbnail') ? $this->file('thumbnail')->store('thumbnail') : null;

        return array_merge($this->validated(), [
            'thumbnail' => is_null($file) && $this->isUpdate() ? $this->post->thumbnail : $this->file('thumbnail')->store('thumbnail'),
        ]);
    }
}
