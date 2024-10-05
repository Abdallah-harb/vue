<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    protected $stopOnFirstFailure =true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|string|max:200",
            "image" => "required_without:id|mimes:jpg,png,jpeg,webp|max:2048",
            "images" => "required_without:id|array",
            "images.*."=>"required_without:id|mimes:jpg,png,jpeg,webp|max:2048",
            "content" => "required_without:id|string",
        ];
    }
}
