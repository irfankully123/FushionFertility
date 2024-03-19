<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientProfileRequest extends FormRequest
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
            'profile' => 'nullable|image|mimes:png,jpeg,jpg|dimensions:width=300,height=300',
            'dob' => 'nullable|date',
            'blood_group' => ['nullable', 'string', Rule::in(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'])],
            'gender' => ['required', 'string', Rule::notIn(['0']), Rule::in(['M', 'F'])],
            'contact' => 'required|min:8|max:16',
            'address' => 'nullable|min:5|max:50',
            'city' => 'required|regex:/^[\pL\s\-]+$/u|max:40',
            'state' => 'nullable|regex:/^[\pL\s\-]+$/u|max:50',
            'zip_code' => 'nullable|min:5|max:8',
            'age' => 'nullable|numeric|min:5|max:100',
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
