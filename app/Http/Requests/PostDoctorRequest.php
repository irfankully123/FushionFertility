<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class PostDoctorRequest extends FormRequest
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
            'userData.name' => 'required|min:5',
            'userData.contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7|max:20',
            'userData.gender' => ['required', 'string', Rule::notIn(['0']), Rule::in(['M', 'F'])],
            'userData.address' => 'required|min:5|max:50',
            'userData.dob' => 'required|date',
            'userData.fee' => 'required|numeric|min:1|max:99999',
            'userData.email' => 'required|unique:users,email',
            'userData.consultant_meeting_time'=>['required', 'string', Rule::notIn(['0']), Rule::in(['15', '20','25','30','35','40','45','60'])],
            'userData.password' => 'required|min:8|max:20|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'userData.confirm' => 'required|min:8|max:20|required_with:userData.password|same:userData.password',
            'profile' => 'required|image|mimes:jpg,jpeg,png|dimensions:width=300,height=300',
            'userExperience.description' => 'required',
            'userExperience.experience' => 'required',
            'userExperience.qualification' => 'required|max:100',
            'schedule' => 'required|array|min:1',
            'schedule.*.isChecked' => 'required|boolean',
            'schedule.*.day' => 'required_if:schedule.*.isChecked,true',
            'schedule.*.time_from' => 'required_if:schedule.*.isChecked,true',
            'schedule.*.time_to' => 'nullable|required_if:schedule.*.isChecked,true|after:schedule.*.time_from',
            'tags' => 'required|array|max:5',
            'zoom.account_id'=>'required|string',
            'zoom.client_id'=>'required|string',
            'zoom.client_secret'=>'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'userData.password.regex' => 'Password is not strong enough eg:Admin@4427',
            'schedule.*.day.required_if' => 'required',
            'schedule.*.time_from.required_if' => 'Time-From required',
            'schedule.*.time_to.required_if' => 'Time-To required',
            'schedule.*.time_to.after'=>'Incorrect time',
            'tags.required' => 'Atleast one tag is required ',
            'userData.fee.numeric' => 'Fee amount is between 1 to 99999 digits',
            'userData.contact.regex' => 'Contact Number are must be valid number e.g: +1234567890',
            'userData.contact.min' => 'Contact Number are must be atleast 7 digits',
            'userData.contact.max' => 'Contact Number are not be exceed by 20 digits',
            'profile.dimensions' => 'Image Ratio is invalid (i.e : Ratio - 300x300 )'

        ];
    }

   public function attributes(): array
    {
        return [
            'userData.name' => 'name',
            'userData.contact' => 'contact',
            'userData.gender' => 'gender',
            'userData.address' => 'address',
            'userData.dob' => 'dob',
            'userData.fee' => 'fee',
            'userData.email' => 'email',
            'userData.consultant_meeting_time'=>'consultant timing',
            'userData.password' => 'password',
            'userData.confirm' => 'confirm',
            'userExperience.description' => 'description',
            'userExperience.experience' => 'experience',
            'userExperience.qualification' => 'qualification',
            'schedule.*.day' => 'day',
            'schedule.*.time_from' => 'timeFrom',
            'schedule.*.time_to' => 'timeTo',
            'zoom.account_id'=>'Account ID',
            'zoom.client_id'=>'Client ID',
            'zoom.client_secret'=>'Client Secret'
        ];
    }


}
