<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"=>"string|min:3",
            "image"=>"nullable|image|mimes:png ,jpeg,gif|max:10000"
            
        ];
    }
    public function messages():array
    {
        return ["name|min"=>"you can't put a name lesser than 3 chars!",
            "name|string"=> "the name must be conposed of letters!",
            "image|image"=>"must upload an image file",
            "image|max"=>"image too big";
        ];
    }
}
