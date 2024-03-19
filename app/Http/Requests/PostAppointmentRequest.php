<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostAppointmentRequest extends FormRequest
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
            'appointment_time' => 'required',
            'appointment_date' => 'required',
            'day' => 'required',
            'appointment_reason' => 'required',
            'prescriptionImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'prescriptionPdf' => 'nullable|mimes:pdf|max:2048',
            'prescriptionDescription' => 'nullable|string|max:255',
        ];
    }




}
