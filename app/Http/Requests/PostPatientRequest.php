<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostPatientRequest extends FormRequest
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
        return [
            'name' => 'required|min:3',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8|max:20|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirm' => 'required|min:8|max:20|required_with:password|same:password',
            'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7|max:20',
            'blood_group' => ['nullable', 'string', Rule::notIn(['0']), Rule::in(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'])],
            'gender' => ['required', 'string', Rule::notIn(['0']), Rule::in(['M', 'F'])],
            'address' => 'nullable|min:5|max:50',
            'zip_code' => 'nullable|regex:/^\d{5}(?:[-\s]\d{4})?$/ | min:5',
            'dob' => 'nullable|date',
            'age' => 'nullable|numeric|min:5|max:100',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|dimensions:width=300,height=300',
            'city' => 'required|regex:/^[\pL\s\-]+$/u|max:40',
            'state' => 'nullable|regex:/^[\pL\s\-]+$/u|max:50',
            'primary_care_physician' => 'nullable|max:255',
            'medical_history' => 'nullable|max:255',
            'current_medications' => 'nullable|max:255'
        ];
    }

    public function messages()
    {
        return [
            'profile.dimensions' => 'Image Ratio is invalid (i.e : Ratio - 300x300 )'
        ];
    }

}
