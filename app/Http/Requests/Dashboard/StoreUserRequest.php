<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|string|unique:users',
            'password' => 'required|min:8|max:20|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirm_password'=>'required|min:8|max:20|required_with:password|same:password'
        ];
    }

    public function messages() :array
    {
        return [
            'password.regex'=>'Password is not strong enough eg:Admin@4427'
        ];
    }
}
