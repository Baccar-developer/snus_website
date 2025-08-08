<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UsersRequest extends FormRequest
{
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
            "tel" =>"required|phone:TN",
            "name"=>"required|string|min:3",
            "password"=> Password::default(function(){
                return Password::min(12)
                ->letters()
                ->numbers()
                ->symbols()
                ->mixedCase()
                ->uncompromised();
            }),
            "password-confirme" =>"required|same:password"
            //
        ];
    }
    
    public function messages(){
        return [
            "tel.required"=>"enter your phone number",
            "tel.phone"=>"enter a valid phone number in tunisia",
            "password.min"=>"your password must contain 8 characters at minimum",
            "password-confirme.same"=>"reconfirme your password"
        ];
    }
}
