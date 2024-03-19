<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class PutUserRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        $user = Route::current()->parameter('user');
        return [
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile'=>'nullable|image|mimes:jpg,png,jpeg|dimensions:width=300,height=300'
        ];
    }

    public function messages():array
    {
         return [
            'password.regex'=>'Password is not strong enough eg:Admin@4427'
        ];
    }
}
