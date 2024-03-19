<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    private function enumDays(): array
    {
        return [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'integer', Rule::exists('patients', 'id')],
            'doctor_id' => ['required', 'integer', Rule::exists('doctors', 'id')],
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'reason' => 'required|string|max:500',
            'day' => ['required', 'string', Rule::notIn(['0']), Rule::in($this->enumDays())],
            'status' => ['required', 'string', Rule::notIn(['0']), Rule::in(['Pending', 'Paid', 'Completed','Meeting'])]
        ];
    }
}
